<?php

declare(strict_types=1);

namespace Alcor\Payroll\Tests\Audit;

use Alcor\Payroll\Audit\Application\Query\GetAudit;
use Alcor\Payroll\Audit\Application\Query\GetLines;
use Alcor\Payroll\Earning\Application\Command\AddAdjustment;
use Alcor\Payroll\Earning\Application\Command\CalculateEarningLine;
use Alcor\Payroll\PayrollApp;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;
use Alcor\Payroll\Tests\SteppingClock;
use Alcor\Payroll\Workforce\Application\Command\HireEmployee;
use Alcor\Payroll\Workforce\Domain\Exception\EmployeeNotFound;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** The read side: date windows, opening balances, per employee, per period, CSV rows. */
final class AuditQueriesTest extends TestCase
{
    private PayrollApp $app;
    private Period $period;

    protected function setUp(): void
    {
        $this->app = PayrollApp::inMemory(new SteppingClock());
        $this->period = Period::parse('2026-01');
        $this->app->commands->dispatch(new HireEmployee('anna', 'Anna Koval', '1000'));
        $this->app->commands->dispatch(new HireEmployee('bohdan', 'Bohdan Melnyk', '2400'));

        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));                                      // 01-01 (hire is 01-01 too: the clock steps per call)
        $this->adjust('-45.55', 'dental');
        $this->adjust('100.10', 'overtime');
    }

    private function adjust(string $amount, string $comment, string $employee = 'anna'): void
    {
        $this->app->commands->dispatch(new AddAdjustment($employee, $this->period, Money::parse($amount), $comment, 'olena'));
    }

    /** @return list<string> */
    private function dates(\Alcor\Payroll\Audit\Application\ReadModel\AuditSection $section): array
    {
        return array_map(static fn ($e) => $e->at->format('m-d'), $section->entries);
    }

    public function test_full_history_has_running_totals_and_no_opening_balance(): void
    {
        $section = $this->app->queries->ask(new GetAudit('anna'))->sections[0];

        $this->assertNull($section->opening);
        $this->assertSame(['$1,000.00', '$954.45', '$1,054.55'], array_map(fn ($e) => $e->runningTotal->format(), $section->entries));
        $this->assertSame('$1,054.55', $section->closing->format());
    }

    public function test_a_date_window_starts_from_an_opening_balance(): void
    {
        $all = $this->app->queries->ask(new GetAudit('anna'))->sections[0];
        $third = $all->entries[2]->at;

        $section = $this->app->queries->ask(new GetAudit('anna', from: $third))->sections[0];

        $this->assertSame('$954.45', $section->opening->format());
        $this->assertSame(['$1,054.55'], array_map(fn ($e) => $e->runningTotal->format(), $section->entries));
    }

    public function test_window_bounds_are_inclusive_and_open_ended_windows_work(): void
    {
        $all = $this->app->queries->ask(new GetAudit('anna'))->sections[0];
        [$first, $second, $third] = array_map(static fn ($e) => $e->at, $all->entries);

        $this->assertCount(2, $this->app->queries->ask(new GetAudit('anna', $second, $third))->sections[0]->entries);
        $this->assertCount(2, $this->app->queries->ask(new GetAudit('anna', to: $second))->sections[0]->entries);
        $this->assertCount(1, $this->app->queries->ask(new GetAudit('anna', $first, $first))->sections[0]->entries);
    }

    public function test_a_window_without_entries_has_no_sections(): void
    {
        $report = $this->app->queries->ask(new GetAudit('anna', from: new DateTimeImmutable('2027-01-01')));

        $this->assertSame([], $report->sections);
    }

    public function test_audit_is_per_employee_and_per_period(): void
    {
        $this->app->commands->dispatch(new CalculateEarningLine('bohdan', $this->period));
        $this->app->commands->dispatch(new CalculateEarningLine('anna', Period::parse('2026-02')));

        $this->assertSame(['2026-01', '2026-02'], array_map(fn ($s) => (string) $s->period, $this->app->queries->ask(new GetAudit('anna'))->sections));
        $this->assertSame(['2026-01'], array_map(fn ($s) => (string) $s->period, $this->app->queries->ask(new GetAudit('bohdan'))->sections));
        $this->assertSame(['2026-02'], array_map(fn ($s) => (string) $s->period, $this->app->queries->ask(new GetAudit('anna', period: Period::parse('2026-02')))->sections));
        $this->assertCount(2, $this->app->queries->ask(new GetLines('anna')));
    }

    public function test_csv_rows_are_flat_and_carry_the_actor(): void
    {
        $rows = $this->app->queries->ask(new GetAudit('anna'))->rows();

        $this->assertCount(3, $rows);
        $this->assertSame(['Anna Koval', '2026-01', 'Adjustment 1', '-45.55', '954.45', 'USD', 'dental', 'olena'], [
            $rows[1]['employee'], $rows[1]['period'], $rows[1]['entry'], $rows[1]['amount'], $rows[1]['running_total'], $rows[1]['currency'], $rows[1]['comment'], $rows[1]['actor'],
        ]);
        $this->assertSame('system', $rows[0]['actor']);
    }

    public function test_an_unknown_employee_is_refused(): void
    {
        $this->expectException(EmployeeNotFound::class);
        $this->app->queries->ask(new GetAudit('nobody'));
    }
}
