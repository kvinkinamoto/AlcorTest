<?php

declare(strict_types=1);

namespace Alcor\Payroll\Tests\Earning;

use Alcor\Payroll\Audit\Application\Query\GetAudit;
use Alcor\Payroll\Audit\Application\Query\GetLine;
use Alcor\Payroll\Earning\Application\Command\AddAdjustment;
use Alcor\Payroll\Earning\Application\Command\CalculateEarningLine;
use Alcor\Payroll\Earning\Domain\CalculationOutcome;
use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\Earning\Domain\Event\AdjustmentAdded;
use Alcor\Payroll\Earning\Domain\Event\LineCalculated;
use Alcor\Payroll\Earning\Domain\Event\RecalculationIgnored;
use Alcor\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use Alcor\Payroll\Earning\Domain\Exception\CommentRequired;
use Alcor\Payroll\Earning\Domain\Exception\LineNotCalculated;
use Alcor\Payroll\PayrollApp;
use Alcor\Payroll\SharedKernel\Application\ConcurrencyConflict;
use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;
use Alcor\Payroll\Tests\SteppingClock;
use Alcor\Payroll\Workforce\Application\Command\ChangeSourceData;
use Alcor\Payroll\Workforce\Application\Command\HireEmployee;
use PHPUnit\Framework\TestCase;

/** The table from the assignment, driven through the public commands and queries only. */
final class AssignmentScenarioTest extends TestCase
{
    private PayrollApp $app;
    private Period $period;

    /** @var list<DomainEvent> */
    private array $published = [];

    protected function setUp(): void
    {
        $this->app = PayrollApp::inMemory(new SteppingClock());
        $this->app->events->subscribe('*', function (DomainEvent $e): void {
            $this->published[] = $e;
        });
        $this->period = Period::parse('2026-01');
        $this->app->commands->dispatch(new HireEmployee('anna', 'Anna Koval', '1000'));
    }

    private function calculate(): CalculationOutcome
    {
        return $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
    }

    private function adjust(string $amount, string $comment): int
    {
        return $this->app->commands->dispatch(new AddAdjustment('anna', $this->period, Money::parse($amount), $comment, 'olena'));
    }

    private function value(): string
    {
        return $this->app->queries->ask(new GetLine('anna', $this->period))->currentValue->format();
    }

    private function runTheTable(): void
    {
        $this->assertSame(CalculationOutcome::Created, $this->calculate());
        $this->assertSame('$1,000.00', $this->value());                                                              // 1

        $this->app->commands->dispatch(new ChangeSourceData('anna', baseSalary: '1050'));
        $this->assertSame(CalculationOutcome::Recalculated, $this->calculate());
        $this->assertSame('$1,050.00', $this->value());                                                              // 2

        $this->adjust('-45.55', 'Employee declined dental benefit; reversing deduction');
        $this->assertSame('$1,004.45', $this->value());                                                              // 3

        $this->app->commands->dispatch(new ChangeSourceData('anna', baseSalary: '2000'));
        $this->assertSame(CalculationOutcome::Ignored, $this->calculate());
        $this->assertSame('$1,004.45', $this->value());                                                              // 4

        $this->adjust('100.10', 'Late correction: missed approved overtime bonus');
        $this->assertSame('$1,104.55', $this->value());                                                              // 5
        $this->adjust('-0.10', 'Minor rounding adjustment');
        $this->assertSame('$1,104.45', $this->value());                                                              // 6
        $this->adjust('-0.20', 'Second minor rounding adjustment');
        $this->assertSame('$1,104.25', $this->value());                                                              // 7
        $this->adjust('0.20', 'Correcting mistake in adjustment #4');
        $this->assertSame('$1,104.45', $this->value());                                                              // 8
    }

    public function test_every_step_of_the_table_gives_the_expected_current_value(): void
    {
        $this->runTheTable();

        $line = $this->app->queries->ask(new GetLine('anna', $this->period));
        $this->assertSame('$1,050.00', $line->systemValue->format(), 'system value frozen at step 3');
        $this->assertTrue($line->frozen);
        $this->assertSame(5, $line->adjustmentCount);
    }

    public function test_the_stored_stream_is_the_history_in_order(): void
    {
        $this->runTheTable();

        $stream = $this->app->eventStore->load((string) new EarningLineId('anna', $this->period));

        $this->assertSame([
            LineCalculated::class,
            SystemValueRecalculated::class,
            AdjustmentAdded::class,
            RecalculationIgnored::class,
            AdjustmentAdded::class,
            AdjustmentAdded::class,
            AdjustmentAdded::class,
            AdjustmentAdded::class,
        ], array_map(static fn ($e) => $e::class, $stream));
    }

    public function test_expected_final_audit_history(): void
    {
        $this->runTheTable();

        $section = $this->app->queries->ask(new GetAudit('anna'))->sections[0];

        $adjustments = array_values(array_filter($section->entries, static fn ($e) => $e->adjustmentNo !== null));
        $this->assertSame(['-$45.55', '+$100.10', '-$0.10', '-$0.20', '+$0.20'], array_map(fn ($e) => $e->amount->format(true), $adjustments));
        $this->assertSame('$1,050.00', $section->systemValue->format());
        $this->assertSame('$1,104.45', $section->currentValue->format());
        $this->assertSame(
            ['System value', 'System value', 'Adjustment 1', 'System recalculation ignored', 'Adjustment 2', 'Adjustment 3', 'Adjustment 4', 'Adjustment 5'],
            array_map(static fn ($e) => $e->label(), $section->entries),
        );
        $this->assertSame(
            ['$1,000.00', '$1,050.00', '$1,004.45', '$1,004.45', '$1,104.55', '$1,104.45', '$1,104.25', '$1,104.45'],
            array_map(static fn ($e) => $e->runningTotal->format(), $section->entries),
        );
    }

    public function test_events_are_published_after_they_are_stored(): void
    {
        $this->runTheTable();

        $earning = array_values(array_filter($this->published, static fn ($e) => str_contains($e::class, '\\Earning\\')));
        $this->assertCount(8, $earning);
        $this->assertInstanceOf(RecalculationIgnored::class, $earning[3]);
    }

    public function test_the_read_model_can_be_rebuilt_from_the_event_store(): void
    {
        $this->runTheTable();
        $before = $this->app->queries->ask(new GetAudit('anna'));

        $replayed = $this->app->rebuildProjections();

        $this->assertSame(8, $replayed);
        $this->assertEquals($before, $this->app->queries->ask(new GetAudit('anna')));
        $this->assertSame('$1,104.45', $this->value());
    }

    public function test_an_adjustment_without_a_comment_is_refused_and_stores_nothing(): void
    {
        $this->calculate();

        try {
            $this->adjust('-5', '   ');
            $this->fail('a comment is mandatory');
        } catch (CommentRequired) {
        }

        $this->assertSame('$1,000.00', $this->value());
        $this->assertCount(1, $this->app->eventStore->load('anna:2026-01'));
    }

    public function test_an_adjustment_before_the_first_calculation_is_refused(): void
    {
        $this->expectException(LineNotCalculated::class);
        $this->adjust('-5', 'too early');
    }

    public function test_the_same_idempotency_key_is_one_adjustment(): void
    {
        $this->calculate();
        $send = fn () => $this->app->commands->dispatch(new AddAdjustment('anna', $this->period, Money::parse('-10'), 'once', 'olena', 'double-click'));

        $this->assertSame($send(), $send());
        $this->assertSame('$990.00', $this->value());
        $this->assertCount(2, $this->app->eventStore->load('anna:2026-01'));
    }

    public function test_a_writer_working_on_a_stale_stream_is_rejected(): void
    {
        $this->calculate();
        $store = $this->app->eventStore;
        $id = new EarningLineId('anna', $this->period);

        $history = $store->load((string) $id);
        $this->adjust('-1', 'first writer wins');

        $this->expectException(ConcurrencyConflict::class);
        $store->append((string) $id, count($history), [$history[0]]); // second writer still believes the stream has 1 event
    }
}
