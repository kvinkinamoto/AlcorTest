<?php

declare(strict_types=1);

namespace App\Payroll\Audit;

use App\Payroll\Money;
use App\Payroll\Period;

/**
 * Audit of one payroll line (one period) inside a date window.
 * `opening` is the line value just before the window (null if the line did not exist yet),
 * so running totals stay correct when the history is filtered.
 */
final readonly class AuditSection
{
    /** @param list<AuditEntry> $entries */
    public function __construct(
        public string $lineId,
        public Period $period,
        public ?Money $opening,
        public array $entries,
        public Money $closing,
        public Money $systemValue,
        public Money $currentValue,
        public bool $frozen,
    ) {}
}
