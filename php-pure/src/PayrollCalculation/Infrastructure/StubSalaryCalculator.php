<?php

declare(strict_types=1);

namespace Alcor\Payroll\PayrollCalculation\Infrastructure;

use Alcor\Payroll\Earning\Application\Port\SalaryCalculator;
use Alcor\Payroll\SharedKernel\Application\QueryBus;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;
use Alcor\Payroll\Workforce\Application\Query\EmployeeView;
use Alcor\Payroll\Workforce\Application\Query\GetEmployee;

/**
 * Stand-in for the real payroll engine, and the anti-corruption layer between it and the Earning context:
 * it asks Workforce for the source data (through a query, never its repository) and returns a plain Money.
 * Formula: base salary - benefits deduction + bonus.
 */
final readonly class StubSalaryCalculator implements SalaryCalculator
{
    public function __construct(private QueryBus $queries) {}

    public function calculate(string $employeeId, Period $period): Money
    {
        /** @var EmployeeView $employee */
        $employee = $this->queries->ask(new GetEmployee($employeeId));

        return $employee->baseSalary->minus($employee->benefitsDeduction)->plus($employee->bonus);
    }
}
