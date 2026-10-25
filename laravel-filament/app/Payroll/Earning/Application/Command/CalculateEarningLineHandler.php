<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Application\Command;

use App\Payroll\Earning\Application\Port\SalaryCalculator;
use App\Payroll\Earning\Domain\CalculationOutcome;
use App\Payroll\Earning\Domain\EarningLine;
use App\Payroll\Earning\Domain\EarningLineId;
use App\Payroll\Earning\Domain\EarningLineRepository;
use App\Payroll\SharedKernel\Application\EventBus;
use App\Payroll\SharedKernel\Application\Transaction;
use Psr\Clock\ClockInterface;

final readonly class CalculateEarningLineHandler
{
    public function __construct(
        private EarningLineRepository $lines,
        private SalaryCalculator $calculator,
        private ClockInterface $clock,
        private EventBus $events,
        private Transaction $transaction,
    ) {}

    public function __invoke(CalculateEarningLine $command): CalculationOutcome
    {
        return $this->transaction->run(function () use ($command): CalculationOutcome {
            $id = new EarningLineId($command->employeeId, $command->period);
            $value = $this->calculator->calculate($command->employeeId, $command->period);

            $line = $this->lines->find($id) ?? EarningLine::start($id);
            $outcome = $line->calculate($value, $this->clock->now());

            $this->lines->save($line);
            $this->events->publish(...$line->pullEvents());

            return $outcome;
        });
    }
}
