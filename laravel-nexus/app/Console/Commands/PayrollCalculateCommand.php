<?php

namespace App\Console\Commands;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Payroll\CalculatePayroll;
use Illuminate\Console\Command;

/** payroll:calculate — runs the salary stub; the line is created, recalculated, or (when frozen) only logged. */
class PayrollCalculateCommand extends Command
{
    protected $signature = 'payroll:calculate {employee : employee id or exact name} {period? : YYYY-MM, default current month}';

    protected $description = 'Calculate (or recalculate) the payroll line of an employee with the salary stub';

    public function handle(CalculatePayroll $calculate): int
    {
        $employee = Employee::query()->where('id', $this->argument('employee'))->orWhere('name', $this->argument('employee'))->firstOrFail();
        $period = $this->argument('period') ?? now()->format('Y-m');

        $outcome = $calculate($employee, $period);
        $line = $employee->payrollLines()->where('period', $period)->firstOrFail();

        $this->info(ucfirst($outcome->value).". Current value: {$line->currentValue()->format()}");

        return self::SUCCESS;
    }
}
