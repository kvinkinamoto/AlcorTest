<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Application\Query;

/** Answers with an EmployeeView, or fails with EmployeeNotFound. */
final readonly class GetEmployee
{
    public function __construct(public string $employeeId) {}
}
