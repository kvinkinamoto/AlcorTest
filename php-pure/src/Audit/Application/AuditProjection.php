<?php

declare(strict_types=1);

namespace Alcor\Payroll\Audit\Application;

use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/** Write side of the read model: how the projector records what happened to a line. */
interface AuditProjection
{
    /** Forgets everything (before a rebuild from the event store). */
    public function reset(): void;

    /** The system set the line's value (first calculation or an allowed recalculation). */
    public function systemValueSet(EarningLineId $id, Money $value, DateTimeImmutable $at): void;

    public function recalculationIgnored(EarningLineId $id, Money $ignoredValue, DateTimeImmutable $at): void;

    public function adjustmentAdded(EarningLineId $id, int $number, Money $amount, string $comment, string $actor, DateTimeImmutable $at): void;
}
