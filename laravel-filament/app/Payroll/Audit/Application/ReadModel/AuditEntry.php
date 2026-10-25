<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application\ReadModel;

use App\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/**
 * One row of the audit table. `amount` is the calculated value for system rows and the
 * signed delta for adjustments; `runningTotal` is the line value right after the row.
 */
final readonly class AuditEntry
{
    public function __construct(
        public int $eventNo,
        public AuditEntryType $type,
        public DateTimeImmutable $at,
        public Money $amount,
        public Money $runningTotal,
        public ?string $comment,
        public ?string $actor,
        public ?int $adjustmentNo = null,
    ) {}

    public function label(): string
    {
        return $this->adjustmentNo === null ? $this->type->label() : "Adjustment {$this->adjustmentNo}";
    }
}
