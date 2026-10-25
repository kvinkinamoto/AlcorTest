<?php

declare(strict_types=1);

namespace Alcor\Payroll\Audit\Application\Query;

use Alcor\Payroll\SharedKernel\Period;

/** Answers with the LineView (current value, system value, frozen) or null if the line does not exist. */
final readonly class GetLine
{
    public function __construct(public string $employeeId, public Period $period) {}
}
