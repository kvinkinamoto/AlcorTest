<?php

namespace App\Payroll;

use App\Nexus\Modules\Employee\Models\Employee;

/** Port to whatever automatically calculates a salary (timesheets, benefits, ...). */
interface SalarySource
{
    public function calculate(Employee $employee, string $period): Money;
}
