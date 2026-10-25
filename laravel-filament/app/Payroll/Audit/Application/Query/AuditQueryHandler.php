<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application\Query;

use App\Payroll\Audit\Application\AuditReadModel;
use App\Payroll\Audit\Application\ReadModel\AuditReport;
use App\Payroll\Audit\Application\ReadModel\LineView;
use App\Payroll\SharedKernel\Application\QueryBus;
use App\Payroll\Workforce\Application\Query\EmployeeView;
use App\Payroll\Workforce\Application\Query\GetEmployee;

/** Handles GetLine, GetLines and GetAudit. Reads only the projections, never the event store. */
final readonly class AuditQueryHandler
{
    public function __construct(
        private AuditReadModel $readModel,
        private QueryBus $queries,
        private AuditSectionAssembler $assembler = new AuditSectionAssembler(),
    ) {}

    public function line(GetLine $query): ?LineView
    {
        return $this->readModel->line($query->employeeId, $query->period);
    }

    /** @return list<LineView> */
    public function lines(GetLines $query): array
    {
        return $this->readModel->linesOf($query->employeeId);
    }

    public function report(GetAudit $query): AuditReport
    {
        /** @var EmployeeView $employee */
        $employee = $this->queries->ask(new GetEmployee($query->employeeId));

        $sections = [];
        foreach ($this->readModel->linesOf($query->employeeId) as $line) {
            if ($query->period !== null && (string) $line->period !== (string) $query->period) {
                continue;
            }
            $section = $this->assembler->assemble($line, $this->readModel->entriesOf($line->employeeId, $line->period), $query->from, $query->to);
            if ($section->entries !== [] || ($query->from === null && $query->to === null)) {
                $sections[] = $section;
            }
        }

        return new AuditReport($employee->id, $employee->name, $query->from, $query->to, $sections);
    }
}
