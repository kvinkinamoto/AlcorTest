<?php

declare(strict_types=1);

namespace Alcor\Payroll\Audit\Application;

use Alcor\Payroll\Audit\Application\ReadModel\AuditEntry;
use Alcor\Payroll\Audit\Application\ReadModel\LineView;
use Alcor\Payroll\SharedKernel\Period;

/** Read side storage: lines and their audit entries, already shaped for display. */
interface AuditReadModel
{
    public function line(string $employeeId, Period $period): ?LineView;

    /** @return list<LineView> ordered by period */
    public function linesOf(string $employeeId): array;

    /** @return list<AuditEntry> the whole history of one line, oldest first, with running totals */
    public function entriesOf(string $employeeId, Period $period): array;
}
