<?php

namespace App\Payroll\Workforce\Infrastructure;

use App\Payroll\SharedKernel\Money;
use App\Payroll\Workforce\Domain\Employee;
use App\Payroll\Workforce\Domain\EmployeeRepository;
use Illuminate\Support\Facades\DB;

/** State-stored employees (`employees`); the Filament resource reads the same table through an Eloquent model. */
final class DbEmployeeRepository implements EmployeeRepository
{
    public function find(string $id): ?Employee
    {
        $row = DB::table('employees')->where('id', $id)->first();

        return $row ? $this->hydrate($row) : null;
    }

    public function all(): array
    {
        return DB::table('employees')->orderBy('name')->get()->map($this->hydrate(...))->all();
    }

    public function save(Employee $employee): void
    {
        $values = [
            'name' => $employee->name(),
            'currency' => $employee->currency(),
            'base_salary' => $employee->baseSalary()->toDecimal(),
            'benefits_deduction' => $employee->benefitsDeduction()->toDecimal(),
            'bonus' => $employee->bonus()->toDecimal(),
            'updated_at' => now(),
        ];

        DB::table('employees')->upsert([['id' => $employee->id, 'created_at' => now(), ...$values]], ['id'], array_keys($values));
    }

    private function hydrate(object $row): Employee
    {
        return Employee::restore(
            (string) $row->id,
            $row->name,
            Money::parse((string) $row->base_salary, $row->currency),
            Money::parse((string) $row->benefits_deduction, $row->currency),
            Money::parse((string) $row->bonus, $row->currency),
        );
    }
}
