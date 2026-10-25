<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Application\Command;

use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;

/** "The specialist corrects this line by a signed amount, for this reason." */
final readonly class AddAdjustment
{
    public function __construct(
        public string $employeeId,
        public Period $period,
        public Money $amount,
        public string $comment,
        public string $actor,
        public ?string $idempotencyKey = null,
    ) {}
}
