<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Application\Command;

/** Amounts are decimal strings ("1050.00"); null means "leave unchanged". */
final readonly class ChangeSourceData
{
    public function __construct(
        public string $employeeId,
        public ?string $baseSalary = null,
        public ?string $benefitsDeduction = null,
        public ?string $bonus = null,
    ) {}
}
