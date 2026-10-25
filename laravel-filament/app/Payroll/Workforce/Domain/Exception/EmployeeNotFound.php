<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Domain\Exception;

use App\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class EmployeeNotFound extends DomainRuleViolation
{
    public static function withId(string $id): self
    {
        return new self("Unknown employee '{$id}'.");
    }
}
