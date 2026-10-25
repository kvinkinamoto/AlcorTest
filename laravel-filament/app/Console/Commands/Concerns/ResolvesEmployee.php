<?php

namespace App\Console\Commands\Concerns;

use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\Workforce\Application\Query\EmployeeView;
use App\Payroll\Workforce\Application\Query\ListEmployees;
use InvalidArgumentException;

trait ResolvesEmployee
{
    /** Finds an employee by id or exact name, through the Workforce query. */
    private function employee(QueryBus $queries, string $key): EmployeeView
    {
        foreach ($queries->ask(new ListEmployees()) as $employee) {
            if ($employee->id === $key || $employee->name === $key) {
                return $employee;
            }
        }

        throw new InvalidArgumentException("Unknown employee '{$key}'.");
    }
}
