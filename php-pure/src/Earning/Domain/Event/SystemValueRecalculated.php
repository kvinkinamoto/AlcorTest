<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain\Event;

use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use Alcor\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/** The source data changed and the system replaced the value; allowed only while the line has no manual correction. */
final readonly class SystemValueRecalculated implements DomainEvent
{
    public function __construct(
        public EarningLineId $lineId,
        public Money $value,
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
        return ['line' => (string) $this->lineId, 'value' => $this->value->toDecimal(), 'currency' => $this->value->currency];
    }

    public static function fromPayload(array $payload, DateTimeImmutable $occurredAt): static
    {
        return new static(EarningLineId::fromString($payload['line']), Money::parse($payload['value'], $payload['currency']), $occurredAt);
    }
}
