<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Application\Command;

use Alcor\Payroll\SharedKernel\Application\EventBus;
use Alcor\Payroll\SharedKernel\Application\Transaction;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\Workforce\Domain\Employee;
use Alcor\Payroll\Workforce\Domain\EmployeeRepository;
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
