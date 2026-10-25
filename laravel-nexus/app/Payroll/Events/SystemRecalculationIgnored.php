<?php

namespace App\Payroll\Events;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

/** A recalculation arrived after the first manual correction: it is logged, the line stays as the specialist left it. */
final readonly class SystemRecalculationIgnored implements ShouldDispatchAfterCommit
{
    public function __construct(
        public int $payrollLineId,
        public string $ignoredValue,
    ) {}
}
