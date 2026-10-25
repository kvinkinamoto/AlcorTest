<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Domain;

interface EmployeeRepository
{
    public function find(string $id): ?Employee;

    /** @return list<Employee> ordered by name */
    public function all(): array;

    public function save(Employee $employee): void;
}
