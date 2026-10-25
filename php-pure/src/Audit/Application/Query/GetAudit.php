<?php

declare(strict_types=1);

namespace Alcor\Payroll\Audit\Application\Query;

use Alcor\Payroll\SharedKernel\Period;
use DateTimeImmutable;

/** Full audit history of an employee, or only the window [from, to] (inclusive), optionally for one period. */
final readonly class GetAudit
{
    public function __construct(
        public string $employeeId,
        public ?DateTimeImmutable $from = null,
        public ?DateTimeImmutable $to = null,
        public ?Period $period = null,
    ) {}
}
