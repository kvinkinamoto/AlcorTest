<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain;

use App\Payroll\Earning\Domain\Event\AdjustmentAdded;
use App\Payroll\Earning\Domain\Event\LineCalculated;
use App\Payroll\Earning\Domain\Event\RecalculationIgnored;
use App\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use App\Payroll\Earning\Domain\Exception\CurrencyMismatch;
use App\Payroll\Earning\Domain\Exception\LineNotCalculated;
use App\Payroll\Earning\Domain\Exception\ZeroAdjustment;
use App\Payroll\SharedKernel\Domain\DomainEvent;
use App\Payroll\SharedKernel\Domain\EventSourcedAggregate;
use App\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/**
 * Aggregate root: the base-salary line of one employee for one month.
 *
 * Event sourced: the only way to change it is to record an event, and its state (system value, current
 * value, "frozen") is nothing but those events applied in order. The two rules of the business case live here:
 *  - a correction is only ever added (there is no edit or delete anywhere in this class);
 *  - after the first correction the system can no longer change the line: its recalculation is recorded as ignored.
 */
final class EarningLine extends EventSourcedAggregate
{
    private ?Money $systemValue = null;
    private ?Money $currentValue = null;
    private int $adjustmentCount = 0;

    /** @var array<string, int> idempotency key => adjustment number */
    private array $keys = [];

    private function __construct(public readonly EarningLineId $id) {}

    /** A line that has no history yet: the next command on it is the first calculation. */
    public static function start(EarningLineId $id): self
    {
        return new self($id);
    }

    /** @param list<DomainEvent> $history */
    public static function fromHistory(EarningLineId $id, array $history): self
    {
        $line = new self($id);
        $line->replay($history);

        return $line;
    }

    public function streamId(): string
    {
        return (string) $this->id;
    }

    /** The system's calculation: creates the line, recalculates it, or - once corrected - is ignored. */
    public function calculate(Money $value, DateTimeImmutable $at): CalculationOutcome
    {
        if ($this->systemValue === null) {
            $this->recordThat(new LineCalculated($this->id, $value, $at));

            return CalculationOutcome::Created;
        }

        $this->assertCurrency($value);

        if ($this->isFrozen()) {
            $this->recordThat(new RecalculationIgnored($this->id, $value, $at));

            return CalculationOutcome::Ignored;
        }

        $this->recordThat(new SystemValueRecalculated($this->id, $value, $at));

        return CalculationOutcome::Recalculated;
    }

    /**
     * Adds a manual correction and returns its number. Sending the same idempotency key again
     * changes nothing and returns the number it got the first time.
     */
    public function adjust(Money $amount, Comment $comment, Actor $actor, DateTimeImmutable $at, ?IdempotencyKey $key = null): int
    {
        if ($this->systemValue === null) {
            throw LineNotCalculated::for($this->id);
        }
        if ($key !== null && isset($this->keys[$key->value])) {
            return $this->keys[$key->value];
        }

        $this->assertCurrency($amount);
        if ($amount->isZero()) {
            throw new ZeroAdjustment();
        }

        $number = $this->adjustmentCount + 1;
        $this->recordThat(new AdjustmentAdded($this->id, $number, $amount, $comment, $actor, $key, $at));

        return $number;
    }

    public function isCalculated(): bool
    {
        return $this->systemValue !== null;
    }

    /** True once the line has at least one manual correction; from then on the system cannot change it. */
    public function isFrozen(): bool
    {
        return $this->adjustmentCount > 0;
    }

    public function systemValue(): ?Money
    {
        return $this->systemValue;
    }

    public function currentValue(): ?Money
    {
        return $this->currentValue;
    }

    public function adjustmentCount(): int
    {
        return $this->adjustmentCount;
    }

    protected function apply(DomainEvent $event): void
    {
        match (true) {
            $event instanceof LineCalculated, $event instanceof SystemValueRecalculated => $this->setSystemValue($event->value),
            $event instanceof AdjustmentAdded => $this->applyAdjustment($event),
            default => null, // RecalculationIgnored leaves the state untouched
        };
    }

    private function setSystemValue(Money $value): void
    {
        $this->systemValue = $value;
        $this->currentValue = $value;
    }

    private function applyAdjustment(AdjustmentAdded $event): void
    {
        $this->currentValue = $this->currentValue->plus($event->amount);
        $this->adjustmentCount = $event->number;
        if ($event->key !== null) {
            $this->keys[$event->key->value] = $event->number;
        }
    }

    private function assertCurrency(Money $money): void
    {
        if ($money->currency !== $this->systemValue->currency) {
            throw CurrencyMismatch::between($this->systemValue->currency, $money->currency);
        }
    }
}
