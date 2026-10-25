<?php

declare(strict_types=1);

namespace Alcor\Payroll\Workforce\Domain\Event;

use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use DateTimeImmutable;

final readonly class EmployeeHired implements DomainEvent
{
    public function __construct(public string $employeeId, public string $name, private DateTimeImmutable $occurredAt) {}

    public function aggregateId(): string
    {
        return $this->employeeId;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function toPayload(): array
    {
        return ['employee' => $this->employeeId, 'name' => $this->name];
    }

    public static function fromPayload(array $payload, DateTimeImmutable $occurredAt): static
    {
        return new static($payload['employee'], $payload['name'], $occurredAt);
    }
}
