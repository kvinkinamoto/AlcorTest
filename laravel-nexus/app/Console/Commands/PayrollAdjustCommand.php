<?php

namespace App\Console\Commands;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Payroll\AdjustPayrollLine;
use Illuminate\Console\Command;

/** payroll:adjust — adds a manual correction (never edits or deletes one). */
class PayrollAdjustCommand extends Command
{
    protected $signature = 'payroll:adjust {employee : employee id or exact name} {period : YYYY-MM} {amount : signed, e.g. -45.55} {comment}
        {--actor= : who made the correction (required)}
        {--key= : idempotency key; re-sending it does not create a duplicate}';

    protected $description = 'Add a manual adjustment to an employee payroll line';

    public function handle(AdjustPayrollLine $adjust): int
    {
        $employee = Employee::query()->where('id', $this->argument('employee'))->orWhere('name', $this->argument('employee'))->firstOrFail();
        $line = $employee->payrollLines()->where('period', $this->argument('period'))->firstOrFail();

        $adjust($line, $this->argument('amount'), $this->argument('comment'), (string) $this->option('actor'), $this->option('key'));

        $this->info("Adjustment saved. Current value: {$line->currentValue()->format()}");

        return self::SUCCESS;
    }
}
