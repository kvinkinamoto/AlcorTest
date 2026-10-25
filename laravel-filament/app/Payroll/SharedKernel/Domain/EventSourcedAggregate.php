<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Domain;

/**
 * Base of an event-sourced aggregate: its state exists only as the result of applying its events.
 * Commands call recordThat(); rebuilding from the stream calls apply() for every stored event.
 */
abstract class EventSourcedAggregate
{
    /** @var list<DomainEvent> recorded but not yet stored */
    private array $uncommitted = [];

    /** @var list<DomainEvent> stored, waiting to be published */
    private array $toPublish = [];

    private int $committedVersion = 0;

    /** @param list<DomainEvent> $history */
    protected function replay(array $history): void
    {
        foreach ($history as $event) {
            $this->apply($event);
        }
        $this->committedVersion = count($history);
    }

    abstract protected function apply(DomainEvent $event): void;

    abstract public function streamId(): string;

    protected function recordThat(DomainEvent $event): void
    {
        $this->apply($event);
        $this->uncommitted[] = $event;
    }

    /** Number of events already stored; the store appends only if the stream is still at this version. */
    public function committedVersion(): int
    {
        return $this->committedVersion;
    }

    /** @return list<DomainEvent> */
    public function uncommittedEvents(): array
    {
        return $this->uncommitted;
    }

    /** Called by the repository after the events were appended. */
    public function markCommitted(): void
    {
        $this->committedVersion += count($this->uncommitted);
        array_push($this->toPublish, ...$this->uncommitted);
        $this->uncommitted = [];
    }

    /** @return list<DomainEvent> stored events to hand to the event bus (once) */
    public function pullEvents(): array
    {
        $events = $this->toPublish;
        $this->toPublish = [];

        return $events;
    }
}
