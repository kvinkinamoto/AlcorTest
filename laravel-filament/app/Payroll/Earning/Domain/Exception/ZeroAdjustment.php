<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain\Exception;

use App\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class ZeroAdjustment extends DomainRuleViolation
{
    public function __construct()
    {
        parent::__construct('An adjustment amount must not be zero.');
    }
}
