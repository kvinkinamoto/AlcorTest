<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Application\Command;

use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;

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
