<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application;

use App\Payroll\Earning\Domain\Event\AdjustmentAdded;
use App\Payroll\Earning\Domain\Event\LineCalculated;
use App\Payroll\Earning\Domain\Event\RecalculationIgnored;
use App\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use App\Payroll\SharedKernel\Domain\DomainEvent;

/** Turns Earning events into read-model updates. Subscribed to the event bus; also used to rebuild from the store. */
final readonly class AuditProjector
{
    public function __construct(private AuditProjection $projection) {}

    public function __invoke(DomainEvent $event): void
    {
        match (true) {
            $event instanceof LineCalculated => $this->projection->systemValueSet($event->lineId, $event->value, $event->occurredAt()),
            $event instanceof SystemValueRecalculated => $this->projection->systemValueSet($event->lineId, $event->value, $event->occurredAt()),
            $event instanceof RecalculationIgnored => $this->projection->recalculationIgnored($event->lineId, $event->ignoredValue, $event->occurredAt()),
            $event instanceof AdjustmentAdded => $this->projection->adjustmentAdded(
                $event->lineId,
                $event->number,
                $event->amount,
                $event->comment->text,
                $event->actor->name,
                $event->occurredAt(),
            ),
            default => null, // events of other contexts are not ours
        };
    }
}
