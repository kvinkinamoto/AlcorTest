<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain\Event;

use Alcor\Payroll\Earning\Domain\Actor;
use Alcor\Payroll\Earning\Domain\Comment;
use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\Earning\Domain\IdempotencyKey;
use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use Alcor\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/** A payroll specialist corrected the line by a signed amount, with a reason. Never edited or removed afterwards. */
final readonly class AdjustmentAdded implements DomainEvent
{
    public function __construct(
        public EarningLineId $lineId,
        public int $number,
        public Money $amount,
        public Comment $comment,
        public Actor $actor,
        public ?IdempotencyKey $key,
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
        return [
            'line' => (string) $this->lineId,
            'number' => $this->number,
            'amount' => $this->amount->toDecimal(),
            'currency' => $this->amount->currency,
            'comment' => $this->comment->text,
            'actor' => $this->actor->name,
            'key' => $this->key?->value,
        ];
    }

    public static function fromPayload(array $payload, DateTimeImmutable $occurredAt): static
    {
        return new static(
            EarningLineId::fromString($payload['line']),
            (int) $payload['number'],
            Money::parse($payload['amount'], $payload['currency']),
            new Comment($payload['comment']),
            new Actor($payload['actor']),
            $payload['key'] === null ? null : new IdempotencyKey($payload['key']),
            $occurredAt,
        );
    }
}
