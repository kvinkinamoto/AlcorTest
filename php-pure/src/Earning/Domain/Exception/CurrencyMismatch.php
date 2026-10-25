<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain\Exception;

use Alcor\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class CurrencyMismatch extends DomainRuleViolation
{
    public static function between(string $lineCurrency, string $given): self
    {
        return new self("Line currency is {$lineCurrency}, got {$given}.");
    }
}
