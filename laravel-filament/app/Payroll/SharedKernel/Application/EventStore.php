<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Application;

use App\Payroll\SharedKernel\Domain\DomainEvent;

/** Append-only store of event streams, one stream per aggregate. */
interface EventStore
{
    /**
     * Appends events to a stream, but only if it still has `$expectedVersion` events.
     *
     * @param list<DomainEvent> $events
     * @throws ConcurrencyConflict when somebody else appended in the meantime
     */
    public function append(string $streamId, int $expectedVersion, array $events): void;

    /** @return list<DomainEvent> the whole stream, oldest first */
    public function load(string $streamId): array;

    /** @return iterable<DomainEvent> every event of every stream in the order it was stored (projection rebuilds) */
    public function all(): iterable;
}
