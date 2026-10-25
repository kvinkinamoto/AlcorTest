<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Application\Command;

use Alcor\Payroll\Earning\Application\Port\SalaryCalculator;
use Alcor\Payroll\Earning\Domain\CalculationOutcome;
use Alcor\Payroll\Earning\Domain\EarningLine;
use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\Earning\Domain\EarningLineRepository;
use Alcor\Payroll\SharedKernel\Application\EventBus;
use Alcor\Payroll\SharedKernel\Application\Transaction;
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
