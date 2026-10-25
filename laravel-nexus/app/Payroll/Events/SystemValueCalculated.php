<?php

namespace App\Payroll\Events;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

/** The system value of a line was set (first calculation) or replaced (recalculation before any manual correction). */
final readonly class SystemValueCalculated implements ShouldDispatchAfterCommit
{
    public function __construct(
        public int $payrollLineId,
        public string $value,
        public bool $firstCalculation,
    ) {}
}
