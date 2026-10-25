<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain\Exception;

use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class LineNotCalculated extends DomainRuleViolation
{
    public static function for(EarningLineId $id): self
    {
        return new self("No earning line for '{$id->employeeId}' in {$id->period}; calculate it first.");
    }
}
