<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain\Exception;

use App\Payroll\Earning\Domain\EarningLineId;
use App\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class LineNotCalculated extends DomainRuleViolation
{
    public static function for(EarningLineId $id): self
    {
        return new self("No earning line for '{$id->employeeId}' in {$id->period}; calculate it first.");
    }
}
