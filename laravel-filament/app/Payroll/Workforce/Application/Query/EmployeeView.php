<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Application\Query;

use App\Payroll\SharedKernel\Money;

/** Read model of an employee: what other contexts and the UI may see (also the salary source data). */
final readonly class EmployeeView
{
    public function __construct(
        public string $id,
        public string $name,
        public string $currency,
        public Money $baseSalary,
        public Money $benefitsDeduction,
        public Money $bonus,
    ) {}
}
