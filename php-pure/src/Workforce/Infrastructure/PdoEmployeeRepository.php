<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Infrastructure;

use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\Workforce\Domain\Employee;
use Alcor\Payroll\Workforce\Domain\EmployeeRepository;
use PDO;

final readonly class PdoEmployeeRepository implements EmployeeRepository
{
    public function __construct(private PDO $pdo, private string $prefix) {}

    public function find(string $id): ?Employee
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}employees WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? $this->hydrate($row) : null;
    }

    public function all(): array
    {
        return array_map($this->hydrate(...), $this->pdo->query("SELECT * FROM {$this->prefix}employees ORDER BY name")->fetchAll());
    }

    public function save(Employee $employee): void
    {
        $this->pdo->prepare(
            "INSERT INTO {$this->prefix}employees (id, name, currency, base_salary_cents, benefits_deduction_cents, bonus_cents)
             VALUES (?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE name = VALUES(name), currency = VALUES(currency), base_salary_cents = VALUES(base_salary_cents),
                 benefits_deduction_cents = VALUES(benefits_deduction_cents), bonus_cents = VALUES(bonus_cents)",
        )->execute([
            $employee->id,
            $employee->name(),
            $employee->currency(),
            $employee->baseSalary()->cents,
            $employee->benefitsDeduction()->cents,
            $employee->bonus()->cents,
        ]);
    }

    /** @param array<string, mixed> $row */
    private function hydrate(array $row): Employee
    {
        $currency = $row['currency'];

        return Employee::restore(
            $row['id'],
            $row['name'],
            Money::cents((int) $row['base_salary_cents'], $currency),
            Money::cents((int) $row['benefits_deduction_cents'], $currency),
            Money::cents((int) $row['bonus_cents'], $currency),
        );
    }
}
