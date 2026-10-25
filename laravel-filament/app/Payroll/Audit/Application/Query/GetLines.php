<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application\Query;

/** Answers with every LineView of an employee, ordered by period. */
final readonly class GetLines
{
    public function __construct(public string $employeeId) {}
}
