<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Application\Port;

use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;

/**
 * What the Earning context needs from payroll calculation: the system's value for an employee and month.
 * Implemented by an anti-corruption adapter in the PayrollCalculation context (a stub here, the real engine later).
 */
interface SalaryCalculator
{
    public function calculate(string $employeeId, Period $period): Money;
}
