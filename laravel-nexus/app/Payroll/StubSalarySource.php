<?php

namespace App\Payroll;

use App\Nexus\Modules\Employee\Models\Employee;

/** Stand-in for the real payroll engine: base salary - benefits deduction + bonus. */
class StubSalarySource implements SalarySource
{
    public function calculate(Employee $employee, string $period): Money
    {
        return $employee->money('base_salary')
            ->minus($employee->money('benefits_deduction'))
            ->plus($employee->money('bonus'));
    }
}
