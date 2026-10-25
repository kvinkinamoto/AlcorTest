<?php

namespace App\Payroll\Events;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;

final readonly class ManualAdjustmentAdded implements ShouldDispatchAfterCommit
{
    public function __construct(
        public int $payrollLineId,
        public int $adjustmentNumber,
        public string $amount,
        public string $comment,
        public string $actor,
    ) {}
}
