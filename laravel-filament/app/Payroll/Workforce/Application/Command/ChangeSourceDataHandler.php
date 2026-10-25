<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Application\Command;

use App\Payroll\SharedKernel\Application\EventBus;
use App\Payroll\SharedKernel\Application\Transaction;
use App\Payroll\SharedKernel\Money;
use App\Payroll\Workforce\Domain\EmployeeRepository;
use App\Payroll\Workforce\Domain\Exception\EmployeeNotFound;
use Psr\Clock\ClockInterface;

final readonly class ChangeSourceDataHandler
{
    public function __construct(
        private EmployeeRepository $employees,
        private ClockInterface $clock,
        private EventBus $events,
        private Transaction $transaction,
    ) {}

    public function __invoke(ChangeSourceData $command): void
    {
        $this->transaction->run(function () use ($command): void {
            $employee = $this->employees->find($command->employeeId) ?? throw EmployeeNotFound::withId($command->employeeId);
            $currency = $employee->currency();

            $employee->changeSourceData(
                $command->baseSalary === null ? null : Money::parse($command->baseSalary, $currency),
                $command->benefitsDeduction === null ? null : Money::parse($command->benefitsDeduction, $currency),
                $command->bonus === null ? null : Money::parse($command->bonus, $currency),
                $this->clock->now(),
            );

            $this->employees->save($employee);
            $this->events->publish(...$employee->pullEvents());
        });
    }
}
