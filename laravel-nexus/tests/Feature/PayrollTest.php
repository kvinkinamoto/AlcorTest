<?php

namespace Tests\Feature;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Nexus\Modules\PayrollAdjustment\Models\PayrollAdjustment;
use App\Nexus\Modules\PayrollAudit\Models\PayrollLineEvent;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\AdjustPayrollLine;
use App\Payroll\Audit\AuditBuilder;
use App\Payroll\AuditTrailIsImmutable;
use App\Payroll\CalculatePayroll;
use App\Payroll\CalculationOutcome;
use App\Payroll\Money;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use LogicException;
use App\Payroll\Events\ManualAdjustmentAdded;
use App\Payroll\Events\SystemRecalculationIgnored;
use App\Payroll\Events\SystemValueCalculated;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PayrollTest extends TestCase
{
    use RefreshDatabase;

    private const PERIOD = '2026-01';

    private Employee $anna;

    protected function setUp(): void
    {
        parent::setUp();

        // Module migrations live inside the modules, in dependency order.
        foreach (['Employee', 'PayrollLine', 'PayrollAudit'] as $module) {
            $this->artisan('migrate', ['--path' => "app/Nexus/Modules/{$module}/database/migrations", '--force' => true]);
        }

        $this->anna = Employee::create(['name' => 'Anna Koval', 'currency' => 'USD', 'base_salary' => '1000.00']);
    }

    protected function tearDown(): void
    {
        $this->travelBack();
        parent::tearDown();
    }

    private function calculate(): CalculationOutcome
    {
        return app(CalculatePayroll::class)($this->anna, self::PERIOD);
    }

    private function line(): PayrollLine
    {
        return PayrollLine::where('employee_id', $this->anna->id)->where('period', self::PERIOD)->firstOrFail();
    }

    private function adjust(string $amount, string $comment, string $actor = 'olena', ?string $key = null): PayrollAdjustment
    {
        return app(AdjustPayrollLine::class)($this->line(), $amount, $comment, $actor, $key);
    }

    private function value(): string
    {
        return $this->line()->currentValue()->format();
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
        $this->assertSame('$1,000.00', $this->value());

        $at();
        $this->anna->update(['base_salary' => '1050.00']);
        $this->assertSame(CalculationOutcome::Recalculated, $this->calculate());
        $this->assertSame('$1,050.00', $this->value());

        $at();
        $this->adjust('-45.55', 'Employee declined dental benefit; reversing deduction');
        $this->assertSame('$1,004.45', $this->value());

        $at();
        $this->anna->update(['base_salary' => '2000.00']);
        $this->assertSame(CalculationOutcome::Ignored, $this->calculate());
        $this->assertSame('$1,004.45', $this->value());

        $at();
        $this->adjust('100.10', 'Late correction: missed approved overtime bonus');
        $this->assertSame('$1,104.55', $this->value());
        $at();
        $this->adjust('-0.10', 'Minor rounding adjustment');
        $this->assertSame('$1,104.45', $this->value());
        $at();
        $this->adjust('-0.20', 'Second minor rounding adjustment');
        $this->assertSame('$1,104.25', $this->value());
        $at();
        $this->adjust('0.20', 'Correcting mistake in adjustment #4');
        $this->assertSame('$1,104.45', $this->value());
    }

    public function test_assignment_scenario_end_to_end(): void
    {
        $this->runAssignmentScenario();

        $line = $this->line();
        $this->assertSame('$1,050.00', $line->systemValue()->format(), 'system value frozen at step 3');
        $this->assertSame(
            ['-$45.55', '+$100.10', '-$0.10', '-$0.20', '+$0.20'],
            $line->adjustments->map(fn ($a) => Money::parse((string) $a->getAttribute('amount'))->format(true))->all(),
        );
        $this->assertSame([1, 2, 3, 4, 5], $line->adjustments->map->getAttribute('sequence')->all());
    }

    public function test_full_audit_history_has_running_totals(): void
    {
        $this->runAssignmentScenario();

        $section = app(AuditBuilder::class)->report($this->anna)->sections[0];

        $this->assertNull($section->opening);
        $this->assertTrue($section->frozen);
        $this->assertSame(
            [
                ['System value', '$1,000.00'],
                ['System value', '$1,050.00'],
                ['Adjustment 1', '$1,004.45'],
                ['System recalculation ignored', '$1,004.45'],
                ['Adjustment 2', '$1,104.55'],
                ['Adjustment 3', '$1,104.45'],
                ['Adjustment 4', '$1,104.25'],
                ['Adjustment 5', '$1,104.45'],
            ],
            array_map(fn ($e) => [$e->label(), $e->runningTotal->format()], $section->entries),
        );
        $this->assertSame('olena', $section->entries[2]->actor);
    }

    public function test_stored_balances_equal_a_recomputation_from_the_events(): void
    {
        $this->runAssignmentScenario();

        $running = null;
        foreach ($this->line()->events as $event) {
            $amount = Money::parse((string) $event->getAttribute('amount'));
            if ($event->getAttribute('kind') === PayrollLineEvent::CALCULATION) {
                $running = $event->getAttribute('applied') ? $amount : $running;
            } else {
                $running = $running->plus($amount);
            }
            $this->assertSame($running->toDecimal(), (string) $event->getAttribute('balance_after'), 'event '.$event->getAttribute('event_no'));
        }
    }

    public function test_date_window_uses_an_opening_balance(): void
    {
        $this->runAssignmentScenario(); // events on 2026-01-01 .. 2026-01-08

        $section = app(AuditBuilder::class)
            ->report($this->anna, CarbonImmutable::parse('2026-01-05'), CarbonImmutable::parse('2026-01-06')->endOfDay())
            ->sections[0];

        $this->assertSame('$1,004.45', $section->opening->format());
        $this->assertSame(['Adjustment 2', 'Adjustment 3'], array_map(fn ($e) => $e->label(), $section->entries));
        $this->assertSame(['$1,104.55', '$1,104.45'], array_map(fn ($e) => $e->runningTotal->format(), $section->entries));
        $this->assertSame('$1,104.45', $section->closing->format());
    }

    public function test_window_boundaries_and_empty_windows(): void
    {
        $this->runAssignmentScenario();

        $only = app(AuditBuilder::class)->report($this->anna, CarbonImmutable::parse('2026-01-03 09:00:00'), CarbonImmutable::parse('2026-01-03 09:00:00'));
        $this->assertSame(['Adjustment 1'], array_map(fn ($e) => $e->label(), $only->sections[0]->entries));

        $this->assertSame([], app(AuditBuilder::class)->report($this->anna, CarbonImmutable::parse('2027-01-01'))->sections);
        $this->assertNull(app(AuditBuilder::class)->report($this->anna, null, CarbonImmutable::parse('2026-01-02')->endOfDay())->sections[0]->opening);
    }

    public function test_audit_is_per_employee_and_per_period(): void
    {
        $bohdan = Employee::create(['name' => 'Bohdan', 'currency' => 'USD', 'base_salary' => '2000.00']);
        $calculate = app(CalculatePayroll::class);
        $calculate($this->anna, self::PERIOD);
        $calculate($this->anna, '2026-02');
        $calculate($bohdan, self::PERIOD);
        $this->adjust('-5', 'anna only');

        $builder = app(AuditBuilder::class);
        $this->assertSame(['2026-01', '2026-02'], array_map(fn ($s) => (string) $s->period, $builder->report($this->anna)->sections));
        $this->assertCount(1, $builder->report($this->anna, period: '2026-02')->sections);
        $this->assertFalse($builder->report($bohdan)->sections[0]->frozen);
        $this->assertSame('$2,000.00', $builder->report($bohdan)->sections[0]->currentValue->format());
    }

    public function test_csv_rows(): void
    {
        $this->runAssignmentScenario();

        $rows = app(AuditBuilder::class)->report($this->anna)->rows();

        $this->assertCount(8, $rows);
        $this->assertSame(
            ['employee' => 'Anna Koval', 'period' => '2026-01', 'date' => '2026-01-03 09:00:00', 'entry' => 'Adjustment 1',
                'amount' => '-45.55', 'running_total' => '1004.45', 'currency' => 'USD',
                'comment' => 'Employee declined dental benefit; reversing deduction', 'actor' => 'olena'],
            $rows[2],
        );
    }

    public function test_stub_salary_uses_base_deduction_and_bonus(): void
    {
        $this->anna->update(['benefits_deduction' => '45.55', 'bonus' => '100.00']);
        $this->calculate();

        $this->assertSame('$1,054.45', $this->value());
    }

    public function test_comment_actor_and_amount_are_mandatory_and_rejections_do_not_freeze(): void
    {
        $this->calculate();

        foreach ([['5', ' ', 'olena'], ['5', 'ok', ' '], ['0', 'ok', 'olena']] as [$amount, $comment, $actor]) {
            try {
                $this->adjust($amount, $comment, $actor);
                $this->fail('expected InvalidArgumentException');
            } catch (InvalidArgumentException) {
            }
        }

        $this->assertFalse($this->line()->isAdjusted());
        $this->anna->update(['base_salary' => '1100.00']);
        $this->assertSame(CalculationOutcome::Recalculated, $this->calculate());
    }

    public function test_adjusting_a_line_that_was_never_calculated_is_impossible(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->adjust('5', 'too early');
    }

    public function test_same_idempotency_key_does_not_duplicate(): void
    {
        $this->calculate();

        $first = $this->adjust('-10', 'once', 'olena', 'double-click');
        $second = $this->adjust('-10', 'once', 'olena', 'double-click');

        $this->assertSame($first->id, $second->id);
        $this->assertSame(1, $this->line()->adjustments()->count());
        $this->assertSame('$990.00', $this->value());
    }

    public function test_audit_entries_cannot_be_updated_or_deleted(): void
    {
        $this->calculate();
        $event = $this->adjust('-10', 'first');

        foreach ([
            fn () => $event->update(['comment' => 'rewritten']),
            fn () => $event->delete(),
            fn () => PayrollLineEvent::query()->find($event->id)->delete(),
            fn () => $this->line()->delete(),
            fn () => $this->anna->delete(),
        ] as $attempt) {
            try {
                $attempt();
                $this->fail('expected AuditTrailIsImmutable');
            } catch (AuditTrailIsImmutable) {
            }
        }

        $this->assertSame('first', $event->fresh()->getAttribute('comment'));
    }

    public function test_payroll_lines_can_only_be_written_by_the_calculation(): void
    {
        $this->calculate();

        foreach ([
            fn () => $this->line()->update(['system_value' => '999999.00']),
            fn () => PayrollLine::create(['employee_id' => $this->anna->id, 'period' => '2030-01', 'currency' => 'USD', 'label' => 'x', 'system_value' => '1.00']),
        ] as $attempt) {
            try {
                $attempt();
                $this->fail('expected LogicException');
            } catch (LogicException) {
            }
        }

        $this->assertSame('$1,000.00', $this->value());
    }

    public function test_currency_cannot_change_once_lines_exist(): void
    {
        $this->calculate();

        $this->expectException(AuditTrailIsImmutable::class);
        $this->anna->update(['currency' => 'EUR']);
    }

    public function test_line_can_go_negative(): void
    {
        $this->calculate();
        $this->adjust('-1500', 'clawback');

        $this->assertSame('-$500.00', $this->value());
    }

    public function test_assignment_scenario_raises_domain_events(): void
    {
        Event::fake([SystemValueCalculated::class, SystemRecalculationIgnored::class, ManualAdjustmentAdded::class]);

        $this->runAssignmentScenario();

        Event::assertDispatchedTimes(SystemValueCalculated::class, 2);      // steps 1 and 2
        Event::assertDispatchedTimes(SystemRecalculationIgnored::class, 1); // step 4
        Event::assertDispatchedTimes(ManualAdjustmentAdded::class, 5);      // steps 3, 5, 6, 7, 8
        Event::assertDispatched(ManualAdjustmentAdded::class, fn ($e) => $e->amount === '-45.55' && $e->adjustmentNumber === 1);
    }
}
