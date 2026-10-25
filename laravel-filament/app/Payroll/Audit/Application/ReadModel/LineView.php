<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application\ReadModel;

use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;

/** Current state of one earning line as the read side sees it. */
final readonly class LineView
{
    public function __construct(
        public string $employeeId,
        public Period $period,
        public Money $systemValue,
        public Money $currentValue,
        public bool $frozen,
        public int $adjustmentCount,
    ) {}

    public function id(): string
    {
        return "{$this->employeeId}:{$this->period}";
    }
}
