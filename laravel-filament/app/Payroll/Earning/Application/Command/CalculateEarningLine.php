<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Application\Command;

use App\Payroll\SharedKernel\Period;

/** "The system calculates (or recalculates) this employee's line for this month." */
final readonly class CalculateEarningLine
{
    public function __construct(public string $employeeId, public Period $period) {}
}
