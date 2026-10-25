<?php

namespace App\Payroll;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Nexus\Modules\PayrollAudit\Models\PayrollLineEvent;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\Events\SystemRecalculationIgnored;
use App\Payroll\Events\SystemValueCalculated;
use Illuminate\Support\Facades\DB;

/** Runs the salary source for an employee and period; creates, recalculates or (when frozen) only logs. */
class CalculatePayroll
{
    public function __construct(private SalarySource $salarySource) {}

    public function __invoke(Employee $employee, string $period): CalculationOutcome
    {
        $period = (string) Period::parse($period);

        return DB::transaction(function () use ($employee, $period) {
            // Serialise writers per employee, so two first calculations cannot both create the line.
            $employee = Employee::query()->whereKey($employee->getKey())->lockForUpdate()->firstOrFail();
            $value = $this->salarySource->calculate($employee, $period)->toDecimal();

            $line = PayrollLine::query()->where('employee_id', $employee->id)->where('period', $period)->lockForUpdate()->first();

            if ($line === null) {
                $line = $this->writeLine(fn () => PayrollLine::create([
                    'employee_id' => $employee->id,
                    'period' => $period,
                    'currency' => $employee->getAttribute('currency'),
                    'label' => $employee->getAttribute('name')." — {$period}",
                    'system_value' => $value,
                ]));
                $this->log($line, $value, true);
                event(new SystemValueCalculated($line->id, $value, true));

                return CalculationOutcome::Created;
            }

            if ($line->isAdjusted()) {
                $this->log($line, $value, false);
                event(new SystemRecalculationIgnored($line->id, $value));

                return CalculationOutcome::Ignored;
            }

            $this->writeLine(fn () => $line->update(['system_value' => $value]));
            $this->log($line, $value, true);
            event(new SystemValueCalculated($line->id, $value, false));

            return CalculationOutcome::Recalculated;
        });
    }

    private function log(PayrollLine $line, string $value, bool $applied): void
    {
        PayrollLineEvent::create([
            'payroll_line_id' => $line->id,
            'kind' => PayrollLineEvent::CALCULATION,
            'amount' => $value,
            'applied' => $applied,
            'comment' => $applied ? null : 'Line already has manual adjustments',
        ]);
    }

    /** Payroll lines accept writes only from here (see PayrollLine::$systemWrite). */
    private function writeLine(callable $write): mixed
    {
        PayrollLine::$systemWrite = true;
        try {
            return $write();
        } finally {
            PayrollLine::$systemWrite = false;
        }
    }
}
