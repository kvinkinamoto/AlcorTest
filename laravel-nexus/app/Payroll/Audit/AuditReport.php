<?php

declare(strict_types=1);

namespace App\Payroll\Audit;

use DateTimeImmutable;

/** Audit of one employee: a section per payroll period, optionally limited to a date window. */
final readonly class AuditReport
{
    /** @param list<AuditSection> $sections */
    public function __construct(
        public string $employeeId,
        public string $employeeName,
        public ?DateTimeImmutable $from,
        public ?DateTimeImmutable $to,
        public array $sections,
    ) {}

    /** @return list<array<string, string>> flat rows, used by the CSV export */
    public function rows(): array
    {
        $rows = [];
        foreach ($this->sections as $section) {
            foreach ($section->entries as $e) {
                $rows[] = [
                    'employee' => $this->employeeName,
                    'period' => (string) $section->period,
                    'date' => $e->at->format('Y-m-d H:i:s'),
                    'entry' => $e->label(),
                    'amount' => $e->amount->toDecimal(),
                    'running_total' => $e->runningTotal->toDecimal(),
                    'currency' => $e->amount->currency,
                    'comment' => $e->comment ?? '',
                    'actor' => $e->actor ?? 'system',
                ];
            }
        }

        return $rows;
    }
}
