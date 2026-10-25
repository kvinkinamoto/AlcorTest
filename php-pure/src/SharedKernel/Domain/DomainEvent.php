<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Domain;

use DateTimeImmutable;

/** A fact that happened in the domain. Immutable; stored as-is by the event store and published to subscribers. */
interface DomainEvent
{
    /** Id of the aggregate (event stream) the event belongs to. */
    public function aggregateId(): string;

    public function occurredAt(): DateTimeImmutable;

    /** @return array<string, mixed> JSON-safe data, without the time (the store keeps that separately) */
    public function toPayload(): array;

    /** @param array<string, mixed> $payload */
    public static function fromPayload(array $payload, DateTimeImmutable $occurredAt): static;
}
