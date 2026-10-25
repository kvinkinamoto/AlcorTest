<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Infrastructure;

use Alcor\Payroll\Earning\Domain\EarningLine;
use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\Earning\Domain\EarningLineRepository;
use Alcor\Payroll\SharedKernel\Application\EventStore;

/** Rebuilds a line from its stream and appends what the line recorded, guarded by the stream version. */
final readonly class EventSourcedEarningLineRepository implements EarningLineRepository
{
    public function __construct(private EventStore $store) {}

    public function find(EarningLineId $id): ?EarningLine
    {
        $history = $this->store->load((string) $id);

        return $history === [] ? null : EarningLine::fromHistory($id, $history);
    }

    public function save(EarningLine $line): void
    {
        $events = $line->uncommittedEvents();
        if ($events === []) {
            return;
        }

        $this->store->append($line->streamId(), $line->committedVersion(), $events);
        $line->markCommitted();
    }
}
