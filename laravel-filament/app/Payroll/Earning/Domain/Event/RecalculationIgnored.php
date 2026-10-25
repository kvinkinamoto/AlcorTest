<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain\Event;

use App\Payroll\Earning\Domain\EarningLineId;
use App\Payroll\SharedKernel\Domain\DomainEvent;
use App\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/** The system tried to recalculate a line that already has a manual correction: recorded, but the line is unchanged. */
final readonly class RecalculationIgnored implements DomainEvent
{
    public function __construct(
        public EarningLineId $lineId,
        public Money $ignoredValue,
        private DateTimeImmutable $occurredAt,
    ) {}

    public function aggregateId(): string
    {
        return (string) $this->lineId;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }

    public function toPayload(): array
    {
        return ['line' => (string) $this->lineId, 'value' => $this->ignoredValue->toDecimal(), 'currency' => $this->ignoredValue->currency];
    }

    public static function fromPayload(array $payload, DateTimeImmutable $occurredAt): static
    {
        return new static(EarningLineId::fromString($payload['line']), Money::parse($payload['value'], $payload['currency']), $occurredAt);
    }
}
