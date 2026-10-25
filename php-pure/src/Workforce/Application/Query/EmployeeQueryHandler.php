<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Application\Query;

use Alcor\Payroll\Workforce\Domain\Employee;
use Alcor\Payroll\Workforce\Domain\EmployeeRepository;
use Alcor\Payroll\Workforce\Domain\Exception\EmployeeNotFound;

/** Handles GetEmployee and ListEmployees. */
final readonly class EmployeeQueryHandler
{
    public function __construct(private EmployeeRepository $employees) {}

    public function get(GetEmployee $query): EmployeeView
    {
        $employee = $this->employees->find($query->employeeId) ?? throw EmployeeNotFound::withId($query->employeeId);

        return $this->view($employee);
    }

    /** @return list<EmployeeView> */
    public function list(ListEmployees $query): array
    {
        return array_map($this->view(...), $this->employees->all());
    }

    private function view(Employee $e): EmployeeView
    {
        return new EmployeeView($e->id, $e->name(), $e->currency(), $e->baseSalary(), $e->benefitsDeduction(), $e->bonus());
    }
}
