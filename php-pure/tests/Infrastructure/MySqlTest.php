<?php

declare(strict_types=1);

namespace Alcor\Payroll\Tests\Infrastructure;

use Alcor\Payroll\Audit\Application\Query\GetAudit;
use Alcor\Payroll\Audit\Application\Query\GetLine;
use Alcor\Payroll\Earning\Application\Command\AddAdjustment;
use Alcor\Payroll\Earning\Application\Command\CalculateEarningLine;
use Alcor\Payroll\Earning\Domain\Exception\LineNotCalculated;
use Alcor\Payroll\MySqlSchema;
use Alcor\Payroll\PayrollApp;
use Alcor\Payroll\SharedKernel\Application\ConcurrencyConflict;
use Alcor\Payroll\SharedKernel\Infrastructure\PdoTransaction;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;
use Alcor\Payroll\Tests\SteppingClock;
use Alcor\Payroll\Workforce\Application\Command\ChangeSourceData;
use Alcor\Payroll\Workforce\Application\Command\HireEmployee;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/** Runs against the real MySQL (own `pure_test_` tables, dropped afterwards): the event store, triggers and projections. */
final class MySqlTest extends TestCase
{
    private const PREFIX = 'pure_test_';

    private PDO $pdo;
    private PayrollApp $app;
    private Period $period;

    protected function setUp(): void
    {
        $this->pdo = MySqlSchema::connectFromEnv();
        MySqlSchema::drop($this->pdo, self::PREFIX);
        MySqlSchema::install($this->pdo, self::PREFIX);

        $this->app = $this->makeApp();
        $this->period = Period::parse('2026-01');
        $this->app->commands->dispatch(new HireEmployee('anna', 'Anna Koval', '1000'));
    }

    protected function tearDown(): void
    {
        MySqlSchema::drop($this->pdo, self::PREFIX);
    }

    /** A new application object over the same database: what a second request or process sees. */
    private function makeApp(): PayrollApp
    {
        return PayrollApp::mysql($this->pdo, new SteppingClock('2026-02-01 09:00:00'), self::PREFIX);
    }

    private function adjust(PayrollApp $app, string $amount, string $comment, ?string $key = null): int
    {
        return $app->commands->dispatch(new AddAdjustment('anna', $this->period, Money::parse($amount), $comment, 'olena', $key));
    }

    private function runTheTable(): void
    {
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
        $this->app->commands->dispatch(new ChangeSourceData('anna', baseSalary: '1050'));
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
        $this->adjust($this->app, '-45.55', 'Employee declined dental benefit; reversing deduction');
        $this->app->commands->dispatch(new ChangeSourceData('anna', baseSalary: '2000'));
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period)); // ignored
        $this->adjust($this->app, '100.10', 'Late correction: missed approved overtime bonus');
        $this->adjust($this->app, '-0.10', 'Minor rounding adjustment');
        $this->adjust($this->app, '-0.20', 'Second minor rounding adjustment');
        $this->adjust($this->app, '0.20', 'Correcting mistake in adjustment #4');
    }

    public function test_the_assignment_table_on_mysql(): void
    {
        $this->runTheTable();

        $fresh = $this->makeApp(); // everything is read back from the database
        $line = $fresh->queries->ask(new GetLine('anna', $this->period));

        $this->assertSame('$1,104.45', $line->currentValue->format());
        $this->assertSame('$1,050.00', $line->systemValue->format());
        $this->assertSame(8, (int) $this->pdo->query('SELECT COUNT(*) FROM ' . self::PREFIX . 'events')->fetchColumn());
        $this->assertSame(
            ['System value', 'System value', 'Adjustment 1', 'System recalculation ignored', 'Adjustment 2', 'Adjustment 3', 'Adjustment 4', 'Adjustment 5'],
            array_map(fn ($e) => $e->label(), $fresh->queries->ask(new GetAudit('anna'))->sections[0]->entries),
        );
    }

    public function test_events_are_stored_as_json_and_survive_a_restart(): void
    {
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
        $this->adjust($this->app, '-45.55', 'dental; reversing', 'k1');

        $row = $this->pdo->query('SELECT event_type, payload FROM ' . self::PREFIX . 'events WHERE version = 2')->fetch();
        $this->assertSame('AdjustmentAdded', $row['event_type']);
        $this->assertSame('-45.55', json_decode($row['payload'], true)['amount']);

        $stream = $this->makeApp()->eventStore->load('anna:2026-01');
        $this->assertCount(2, $stream);
    }

    public function test_the_database_refuses_to_update_or_delete_events(): void
    {
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
        $this->adjust($this->app, '-10', 'first');

        foreach (["UPDATE %s SET payload = '{}'", 'DELETE FROM %s'] as $sql) {
            try {
                $this->pdo->exec(sprintf($sql, self::PREFIX . 'events'));
                $this->fail('the append-only trigger should have refused: ' . $sql);
            } catch (PDOException $e) {
                $this->assertStringContainsString('append-only', $e->getMessage());
            }
        }

        $this->assertSame(2, (int) $this->pdo->query('SELECT COUNT(*) FROM ' . self::PREFIX . 'events')->fetchColumn());
    }

    public function test_two_writers_on_the_same_stream_version_collide(): void
    {
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
        $store = $this->app->eventStore;

        $history = $store->load('anna:2026-01');                // both writers see version 1
        $this->adjust($this->makeApp(), '-1', 'writer A');       // A appends version 2

        $this->expectException(ConcurrencyConflict::class);
        $store->append('anna:2026-01', count($history), [$history[0]]); // B tries version 2 as well
    }

    public function test_the_idempotency_key_holds_across_requests(): void
    {
        $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period));
        $this->adjust($this->app, '-10', 'once', 'double-click');
        $this->adjust($this->makeApp(), '-10', 'once', 'double-click');

        $this->assertSame(2, (int) $this->pdo->query('SELECT COUNT(*) FROM ' . self::PREFIX . 'events')->fetchColumn());
        $this->assertSame('$990.00', $this->makeApp()->queries->ask(new GetLine('anna', $this->period))->currentValue->format());
    }

    public function test_a_refused_command_stores_nothing(): void
    {
        try {
            $this->adjust($this->app, '-10', 'there is no line yet');
            $this->fail('the line was never calculated');
        } catch (LineNotCalculated) {
        }

        $this->assertSame(0, (int) $this->pdo->query('SELECT COUNT(*) FROM ' . self::PREFIX . 'events')->fetchColumn());
    }

    public function test_events_and_projection_roll_back_together(): void
    {
        $transaction = new PdoTransaction($this->pdo);

        try {
            $transaction->run(function (): void {
                $this->app->commands->dispatch(new CalculateEarningLine('anna', $this->period)); // joins this transaction
                throw new RuntimeException('something later in the unit of work failed');
            });
        } catch (RuntimeException) {
        }

        $this->assertSame(0, (int) $this->pdo->query('SELECT COUNT(*) FROM ' . self::PREFIX . 'events')->fetchColumn());
        $this->assertSame(0, (int) $this->pdo->query('SELECT COUNT(*) FROM ' . self::PREFIX . 'line_view')->fetchColumn());
    }

    public function test_the_projection_is_rebuilt_from_the_stored_events(): void
    {
        $this->runTheTable();
        $before = $this->app->queries->ask(new GetAudit('anna'));

        $this->pdo->exec('DELETE FROM ' . self::PREFIX . 'audit_entry');
        $this->pdo->exec('DELETE FROM ' . self::PREFIX . 'line_view');
        $this->assertNull($this->app->queries->ask(new GetLine('anna', $this->period)), 'the read model is disposable');

        $this->assertSame(8, $this->app->rebuildProjections());
        $this->assertEquals($before, $this->app->queries->ask(new GetAudit('anna')));
    }
}
