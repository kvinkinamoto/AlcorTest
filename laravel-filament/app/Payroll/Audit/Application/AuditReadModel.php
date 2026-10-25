<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application;

use App\Payroll\Audit\Application\ReadModel\AuditEntry;
use App\Payroll\Audit\Application\ReadModel\LineView;
use App\Payroll\SharedKernel\Period;

/** Read side storage: lines and their audit entries, already shaped for display. */
interface AuditReadModel
{
    public function line(string $employeeId, Period $period): ?LineView;

    /** @return list<LineView> ordered by period */
    public function linesOf(string $employeeId): array;

    /** @return list<AuditEntry> the whole history of one line, oldest first, with running totals */
    public function entriesOf(string $employeeId, Period $period): array;
}
