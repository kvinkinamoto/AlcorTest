<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Infrastructure;

use Alcor\Payroll\Workforce\Domain\Employee;
use Alcor\Payroll\Workforce\Domain\EmployeeRepository;

final class InMemoryEmployeeRepository implements EmployeeRepository
{
    /** @var array<string, Employee> */
    private array $employees = [];

    public function find(string $id): ?Employee
    {
        return $this->employees[$id] ?? null;
    }

    public function all(): array
    {
        $all = array_values($this->employees);
        usort($all, static fn (Employee $a, Employee $b) => $a->name() <=> $b->name());

        return $all;
    }

    public function save(Employee $employee): void
    {
        $this->employees[$employee->id] = $employee;
    }
}
