<?php

declare(strict_types=1);

namespace App\Payroll\Workforce\Domain\Event;

use App\Payroll\SharedKernel\Domain\DomainEvent;
use DateTimeImmutable;

/** The data a salary is calculated from changed. Other contexts may react (e.g. schedule a recalculation). */
final readonly class EmployeeSourceDataChanged implements DomainEvent
{
    public function __construct(public string $employeeId, private DateTimeImmutable $occurredAt) {}

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
        return ['employee' => $this->employeeId];
    }

    public static function fromPayload(array $payload, DateTimeImmutable $occurredAt): static
    {
        return new static($payload['employee'], $occurredAt);
    }
}
