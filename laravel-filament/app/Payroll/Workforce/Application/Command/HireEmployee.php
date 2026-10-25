<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Application\Command;

final readonly class HireEmployee
{
    public function __construct(
        public string $employeeId,
        public string $name,
        public string $baseSalary,
        public string $currency = 'USD',
    ) {}
}
