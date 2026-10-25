<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Application\Command;

use App\Payroll\SharedKernel\Application\EventBus;
use App\Payroll\SharedKernel\Application\Transaction;
use App\Payroll\SharedKernel\Money;
use App\Payroll\Workforce\Domain\Employee;
use App\Payroll\Workforce\Domain\EmployeeRepository;
use Psr\Clock\ClockInterface;

final readonly class HireEmployeeHandler
{
    public function __construct(
        private EmployeeRepository $employees,
        private ClockInterface $clock,
        private EventBus $events,
        private Transaction $transaction,
    ) {}

    public function __invoke(HireEmployee $command): void
    {
        $this->transaction->run(function () use ($command): void {
            $employee = Employee::hire($command->employeeId, $command->name, Money::parse($command->baseSalary, $command->currency), $this->clock->now());

            $this->employees->save($employee);
            $this->events->publish(...$employee->pullEvents());
        });
    }
}
