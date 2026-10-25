<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Application\Command;

use Alcor\Payroll\Earning\Domain\Actor;
use Alcor\Payroll\Earning\Domain\Comment;
use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\Earning\Domain\EarningLineRepository;
use Alcor\Payroll\Earning\Domain\Exception\LineNotCalculated;
use Alcor\Payroll\Earning\Domain\IdempotencyKey;
use Alcor\Payroll\SharedKernel\Application\EventBus;
use Alcor\Payroll\SharedKernel\Application\Transaction;
use Psr\Clock\ClockInterface;

final readonly class AddAdjustmentHandler
{
    public function __construct(
        private EarningLineRepository $lines,
        private ClockInterface $clock,
        private EventBus $events,
        private Transaction $transaction,
    ) {}

    /** @return int the number of the adjustment on its line (the existing one when the idempotency key was already used) */
    public function __invoke(AddAdjustment $command): int
    {
        // Value objects validate the input before anything is loaded.
        $comment = new Comment($command->comment);
        $actor = new Actor($command->actor);
        $key = $command->idempotencyKey === null ? null : new IdempotencyKey($command->idempotencyKey);

        return $this->transaction->run(function () use ($command, $comment, $actor, $key): int {
            $id = new EarningLineId($command->employeeId, $command->period);
            $line = $this->lines->find($id) ?? throw LineNotCalculated::for($id);

            $number = $line->adjust($command->amount, $comment, $actor, $this->clock->now(), $key);

            $this->lines->save($line);
            $this->events->publish(...$line->pullEvents());

            return $number;
        });
    }
}
