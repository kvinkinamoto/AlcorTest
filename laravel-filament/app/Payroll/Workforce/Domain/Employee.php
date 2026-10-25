<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Domain;

use App\Payroll\SharedKernel\Domain\DomainEvent;
use App\Payroll\SharedKernel\Money;
use App\Payroll\Workforce\Domain\Event\EmployeeHired;
use App\Payroll\Workforce\Domain\Event\EmployeeSourceDataChanged;
use DateTimeImmutable;
use InvalidArgumentException;

/**
 * Aggregate root: an employee and the source data their salary is calculated from.
 * State-stored (a plain row) - only the Earning line needs a full history - but it still raises events.
 */
final class Employee
{
    /** @var list<DomainEvent> */
    private array $raised = [];

    private function __construct(
        public readonly string $id,
        private string $name,
        private Money $baseSalary,
        private Money $benefitsDeduction,
        private Money $bonus,
    ) {
        if (trim($id) === '' || trim($name) === '') {
            throw new InvalidArgumentException('An employee needs an id and a name.');
        }
        foreach ([$benefitsDeduction, $bonus] as $amount) {
            if ($amount->currency !== $baseSalary->currency) {
                throw new InvalidArgumentException('All salary source amounts must use the same currency.');
            }
        }
    }

    public static function hire(string $id, string $name, Money $baseSalary, DateTimeImmutable $at): self
    {
        $employee = new self($id, $name, $baseSalary, Money::zero($baseSalary->currency), Money::zero($baseSalary->currency));
        $employee->raised[] = new EmployeeHired($id, $name, $at);

        return $employee;
    }

    /** Rebuilds a stored employee (repositories only); raises nothing. */
    public static function restore(string $id, string $name, Money $baseSalary, Money $benefitsDeduction, Money $bonus): self
    {
        return new self($id, $name, $baseSalary, $benefitsDeduction, $bonus);
    }

    /** Changing the source data is what makes a later salary calculation differ. */
    public function changeSourceData(?Money $baseSalary, ?Money $benefitsDeduction, ?Money $bonus, DateTimeImmutable $at): void
    {
        $new = new self($this->id, $this->name, $baseSalary ?? $this->baseSalary, $benefitsDeduction ?? $this->benefitsDeduction, $bonus ?? $this->bonus);
        $this->baseSalary = $new->baseSalary;
        $this->benefitsDeduction = $new->benefitsDeduction;
        $this->bonus = $new->bonus;
        $this->raised[] = new EmployeeSourceDataChanged($this->id, $at);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function currency(): string
    {
        return $this->baseSalary->currency;
    }

    public function baseSalary(): Money
    {
        return $this->baseSalary;
    }

    public function benefitsDeduction(): Money
    {
        return $this->benefitsDeduction;
    }

    public function bonus(): Money
    {
        return $this->bonus;
    }

    /** @return list<DomainEvent> */
    public function pullEvents(): array
    {
        $events = $this->raised;
        $this->raised = [];

        return $events;
    }
}
