<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Infrastructure;

use Alcor\Payroll\SharedKernel\Application\ConcurrencyConflict;
use Alcor\Payroll\SharedKernel\Application\EventStore;
use Alcor\Payroll\SharedKernel\Domain\DomainEvent;

final class InMemoryEventStore implements EventStore
{
    /** @var array<string, list<DomainEvent>> */
    private array $streams = [];

    /** @var list<DomainEvent> */
    private array $global = [];

    public function append(string $streamId, int $expectedVersion, array $events): void
    {
        if (count($this->streams[$streamId] ?? []) !== $expectedVersion) {
            throw ConcurrencyConflict::forStream($streamId, $expectedVersion);
        }
        foreach ($events as $event) {
            $this->streams[$streamId][] = $event;
            $this->global[] = $event;
        }
    }

    public function load(string $streamId): array
    {
        return $this->streams[$streamId] ?? [];
    }

    public function all(): iterable
    {
        return $this->global;
    }
}
