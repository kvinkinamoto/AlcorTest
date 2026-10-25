<?php

namespace Tests\Feature;

use App\Filament\Pages\PayrollAudit;
use App\Filament\Resources\Employees\Pages\CreateEmployee;
use App\Filament\Resources\Employees\Pages\EditEmployee;
use App\Filament\Resources\Employees\Pages\ListEmployees;
use App\Filament\Resources\Employees\RelationManagers\PayrollLinesRelationManager;
use App\Models\Employee;
use App\Models\PayrollLine;
use App\Models\User;
use App\Payroll\Audit\Application\Query\GetAudit;
use App\Payroll\Audit\Application\Query\GetLine;
use App\Payroll\Audit\Application\RebuildAuditProjection;
use App\Payroll\Earning\Application\Command\AddAdjustment;
use App\Payroll\Earning\Application\Command\CalculateEarningLine;
use App\Payroll\Earning\Domain\CalculationOutcome;
use App\Payroll\Earning\Domain\Event\AdjustmentAdded;
use App\Payroll\Earning\Domain\Event\LineCalculated;
use App\Payroll\Earning\Domain\Event\RecalculationIgnored;
use App\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use App\Payroll\Earning\Domain\Exception\CommentRequired;
use App\Payroll\Earning\Domain\Exception\CurrencyMismatch;
use App\Payroll\Earning\Domain\Exception\LineNotCalculated;
use App\Payroll\SharedKernel\Application\CommandBus;
use App\Payroll\SharedKernel\Application\ConcurrencyConflict;
use App\Payroll\SharedKernel\Application\EventStore;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\SharedKernel\Domain\DomainEvent;
use App\Payroll\SharedKernel\Infrastructure\SynchronousEventBus;
use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;
use App\Payroll\Workforce\Application\Command\ChangeSourceData;
use App\Payroll\Workforce\Application\Command\HireEmployee;
use Carbon\CarbonImmutable;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

/** The table from the assignment through the commands and queries, plus the admin panel on top of them. */
class PayrollTest extends TestCase
{
    use RefreshDatabase;

    private const PERIOD = '2026-01';

    private CommandBus $commands;
    private QueryBus $queries;
    private Period $period;

    /** @var list<DomainEvent> */
    private array $published = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->commands = app(CommandBus::class);
        $this->queries = app(QueryBus::class);
        $this->period = Period::parse(self::PERIOD);
        app(SynchronousEventBus::class)->subscribe('*', function (DomainEvent $e): void {
            $this->published[] = $e;
        });

        $this->commands->dispatch(new HireEmployee('anna', 'Anna Koval', '1000.00'));
    }

    private function calculate(): CalculationOutcome
    {
        return $this->commands->dispatch(new CalculateEarningLine('anna', $this->period));
    }

    private function adjust(string $amount, string $comment, string $actor = 'olena', ?string $key = null): int
    {
        return $this->commands->dispatch(new AddAdjustment('anna', $this->period, Money::parse($amount), $comment, $actor, $key));
    }

    private function value(): string
    {
        return $this->queries->ask(new GetLine('anna', $this->period))->currentValue->format();
    }

    private function eventCount(): int
    {
        return DB::table('payroll_events')->count();
    }

    /** Replays the assignment table, one step per day from 2026-01-01. */
    private function runAssignmentScenario(): void
    {
        $day = CarbonImmutable::parse('2026-01-01 09:00:00');
        $at = function () use (&$day) {
            $this->travelTo($day);
            $day = $day->addDay();
        };

        $at();
        $this->assertSame(CalculationOutcome::Created, $this->calculate());
        $this->assertSame('$1,000.00', $this->value());                                          // 1

        $at();
        $this->commands->dispatch(new ChangeSourceData('anna', baseSalary: '1050.00'));
        $this->assertSame(CalculationOutcome::Recalculated, $this->calculate());
        $this->assertSame('$1,050.00', $this->value());                                          // 2

        $at();
        $this->adjust('-45.55', 'Employee declined dental benefit; reversing deduction');
        $this->assertSame('$1,004.45', $this->value());                                          // 3

        $at();
        $this->commands->dispatch(new ChangeSourceData('anna', baseSalary: '2000.00'));
        $this->assertSame(CalculationOutcome::Ignored, $this->calculate());
        $this->assertSame('$1,004.45', $this->value());                                          // 4

        $at();
        $this->adjust('100.10', 'Late correction: missed approved overtime bonus');
        $this->assertSame('$1,104.55', $this->value());                                          // 5
        $at();
        $this->adjust('-0.10', 'Minor rounding adjustment');
        $this->assertSame('$1,104.45', $this->value());                                          // 6
        $at();
        $this->adjust('-0.20', 'Second minor rounding adjustment');
        $this->assertSame('$1,104.25', $this->value());                                          // 7
        $at();
        $this->adjust('0.20', 'Correcting mistake in adjustment #4');
        $this->assertSame('$1,104.45', $this->value());                                          // 8
    }

    public function test_every_step_of_the_table_gives_the_expected_current_value(): void
    {
        $this->runAssignmentScenario();

        $line = $this->queries->ask(new GetLine('anna', $this->period));
        $this->assertSame('$1,050.00', $line->systemValue->format(), 'system value frozen at step 3');
        $this->assertTrue($line->frozen);
        $this->assertSame(5, $line->adjustmentCount);
    }

    public function test_the_stored_stream_is_the_history_in_order(): void
    {
        $this->runAssignmentScenario();

        $stream = app(EventStore::class)->load('anna:'.self::PERIOD);

        $this->assertSame([
            LineCalculated::class,
            SystemValueRecalculated::class,
            AdjustmentAdded::class,
            RecalculationIgnored::class,
            AdjustmentAdded::class,
            AdjustmentAdded::class,
            AdjustmentAdded::class,
            AdjustmentAdded::class,
        ], array_map(fn ($e) => $e::class, $stream));
    }

    public function test_expected_final_audit_history(): void
    {
        $this->runAssignmentScenario();

        $section = $this->queries->ask(new GetAudit('anna'))->sections[0];

        $adjustments = array_values(array_filter($section->entries, fn ($e) => $e->adjustmentNo !== null));
        $this->assertSame(['-$45.55', '+$100.10', '-$0.10', '-$0.20', '+$0.20'], array_map(fn ($e) => $e->amount->format(true), $adjustments));
        $this->assertSame(
            ['System value', 'System value', 'Adjustment 1', 'System recalculation ignored', 'Adjustment 2', 'Adjustment 3', 'Adjustment 4', 'Adjustment 5'],
            array_map(fn ($e) => $e->label(), $section->entries),
        );
        $this->assertSame(
            ['$1,000.00', '$1,050.00', '$1,004.45', '$1,004.45', '$1,104.55', '$1,104.45', '$1,104.25', '$1,104.45'],
            array_map(fn ($e) => $e->runningTotal->format(), $section->entries),
        );
    }

    public function test_events_are_published_after_they_are_stored(): void
    {
        $this->runAssignmentScenario();

        $earning = array_values(array_filter($this->published, fn ($e) => str_contains($e::class, '\\Earning\\')));
        $this->assertCount(8, $earning);
        $this->assertInstanceOf(RecalculationIgnored::class, $earning[3]);
    }

    public function test_the_read_model_can_be_rebuilt_from_the_event_store(): void
    {
        $this->runAssignmentScenario();
        $before = $this->queries->ask(new GetAudit('anna'));

        DB::table('payroll_audit_entries')->delete();
        DB::table('payroll_line_views')->delete();
        $this->assertNull($this->queries->ask(new GetLine('anna', $this->period)), 'the read model is disposable');

        $this->assertSame(8, app(RebuildAuditProjection::class)());
        $this->assertEquals($before, $this->queries->ask(new GetAudit('anna')));
    }

    public function test_rejected_commands_store_nothing_and_do_not_freeze(): void
    {
        $this->expectRefusal(LineNotCalculated::class, fn () => $this->adjust('-5', 'too early'));

        $this->calculate();
        $this->expectRefusal(CommentRequired::class, fn () => $this->adjust('5', '  '));
        $this->expectRefusal(CurrencyMismatch::class, fn () => $this->commands->dispatch(new AddAdjustment('anna', $this->period, Money::parse('5', 'EUR'), 'wrong currency', 'olena')));

        $this->assertSame(1, $this->eventCount());
        $this->commands->dispatch(new ChangeSourceData('anna', baseSalary: '1100.00'));
        $this->assertSame(CalculationOutcome::Recalculated, $this->calculate());
    }

    public function test_the_same_idempotency_key_is_one_adjustment(): void
    {
        $this->calculate();

        $this->assertSame($this->adjust('-10', 'once', 'olena', 'double-click'), $this->adjust('-10', 'once', 'olena', 'double-click'));
        $this->assertSame('$990.00', $this->value());
        $this->assertSame(2, $this->eventCount());
    }

    public function test_a_writer_on_a_stale_stream_is_rejected(): void
    {
        $this->calculate();
        $store = app(EventStore::class);

        $history = $store->load('anna:'.self::PERIOD);
        $this->adjust('-1', 'first writer wins');

        $this->expectException(ConcurrencyConflict::class);
        $store->append('anna:'.self::PERIOD, count($history), [$history[0]]);
    }

    public function test_stub_salary_uses_base_deduction_and_bonus(): void
    {
        $this->commands->dispatch(new ChangeSourceData('anna', benefitsDeduction: '45.55', bonus: '100.00'));
        $this->calculate();

        $this->assertSame('$1,054.45', $this->value());
    }

    public function test_the_line_can_go_negative(): void
    {
        $this->calculate();
        $this->adjust('-1500', 'clawback');

        $this->assertSame('-$500.00', $this->value());
    }

    public function test_specialist_adds_adjustment_through_filament_and_actor_is_the_logged_in_user(): void
    {
        $this->actingAs(User::factory()->create(['name' => 'Olena']));
        $this->calculate();

        Livewire::test(PayrollLinesRelationManager::class, ['ownerRecord' => Employee::find('anna'), 'pageClass' => EditEmployee::class])
            ->callAction(TestAction::make('adjust')->table(PayrollLine::find('anna:'.self::PERIOD)), ['amount' => '-45.55', 'comment' => 'Declined dental', 'key' => 'k-1'])
            ->assertHasNoActionErrors();

        $this->assertSame('$954.45', $this->value());
        $this->assertSame('Olena', $this->queries->ask(new GetAudit('anna'))->sections[0]->entries[1]->actor);
    }

    public function test_filament_requires_a_comment(): void
    {
        $this->actingAs(User::factory()->create());
        $this->calculate();

        Livewire::test(PayrollLinesRelationManager::class, ['ownerRecord' => Employee::find('anna'), 'pageClass' => EditEmployee::class])
            ->callAction(TestAction::make('adjust')->table(PayrollLine::find('anna:'.self::PERIOD)), ['amount' => '5', 'comment' => '', 'key' => 'k-1'])
            ->assertHasActionErrors(['comment' => 'required']);

        $this->assertSame(1, $this->eventCount());
    }

    public function test_employee_pages_hire_edit_and_calculate_through_commands(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(ListEmployees::class)->assertCanSeeTableRecords([Employee::find('anna')]);

        Livewire::test(CreateEmployee::class)
            ->fillForm(['name' => 'Bohdan Melnyk', 'currency' => 'EUR', 'base_salary' => '2400.00', 'benefits_deduction' => '0.00', 'bonus' => '50.00'])
            ->call('create')
            ->assertHasNoFormErrors();
        $bohdan = Employee::query()->where('name', 'Bohdan Melnyk')->firstOrFail();
        $this->assertSame('EUR', $bohdan->currency);

        Livewire::test(EditEmployee::class, ['record' => $bohdan->getKey()])
            ->fillForm(['base_salary' => '2500.00', 'benefits_deduction' => '0.00', 'bonus' => '50.00'])
            ->call('save')
            ->assertHasNoFormErrors()
            ->callAction('calculate', ['period' => self::PERIOD])
            ->assertHasNoActionErrors();

        $this->assertSame('€2,550.00', $this->queries->ask(new GetLine((string) $bohdan->getKey(), $this->period))->currentValue->format());
    }

    public function test_audit_page_filters_by_date_window(): void
    {
        $this->actingAs(User::factory()->create());
        $this->runAssignmentScenario();
        $this->travelBack();

        Livewire::test(PayrollAudit::class)
            ->set('data.employee_id', 'anna')
            ->assertSee('Employee declined dental benefit')
            ->assertSee('System recalculation ignored')
            ->assertDontSee('Opening balance')
            ->set('data.from', '2026-01-05')
            ->assertDontSee('Employee declined dental benefit')
            ->assertSee('Opening balance')
            ->assertSee('$1,004.45')
            ->assertSee('Late correction: missed approved overtime bonus')
            ->set('data.to', '2026-01-05')
            ->assertSee('Late correction')
            ->assertDontSee('Minor rounding adjustment');
    }

    /** @param class-string<\Throwable> $class */
    private function expectRefusal(string $class, callable $fn): void
    {
        try {
            $fn();
            $this->fail("Expected {$class}");
        } catch (\Throwable $e) {
            $this->assertInstanceOf($class, $e);
        }
    }
}
