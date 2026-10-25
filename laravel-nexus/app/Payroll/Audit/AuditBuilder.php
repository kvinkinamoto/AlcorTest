<?php

namespace App\Payroll\Audit;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Nexus\Modules\PayrollAudit\Models\PayrollLineEvent;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\Money;
use App\Payroll\Period;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * Audit of an employee: a section per period with rows (system calculations, ignored attempts,
 * adjustments). Every stored event already carries the balance after it, so a date window
 * is a plain filter; the opening balance is the balance of the last event before the window.
 */
class AuditBuilder
{
    public function report(Employee $employee, ?DateTimeInterface $from = null, ?DateTimeInterface $to = null, ?string $period = null): AuditReport
    {
        $lines = $employee->payrollLines()
            ->when($period, fn ($q) => $q->where('period', $period))
            ->get();

        $sections = [];
        foreach ($lines as $line) {
            $section = $this->section($line, $from, $to);
            if ($section->entries !== [] || ($from === null && $to === null)) {
                $sections[] = $section;
            }
        }

        return new AuditReport(
            (string) $employee->id,
            $employee->getAttribute('name'),
            $from ? DateTimeImmutable::createFromInterface($from) : null,
            $to ? DateTimeImmutable::createFromInterface($to) : null,
            $sections,
        );
    }

    public function section(PayrollLine $line, ?DateTimeInterface $from = null, ?DateTimeInterface $to = null): AuditSection
    {
        $currency = $line->getAttribute('currency');

        $opening = null;
        if ($from !== null) {
            $before = $line->events()->where('occurred_at', '<', $from)->reorder('event_no', 'desc')->value('balance_after');
            $opening = $before === null ? null : Money::parse((string) $before, $currency);
        }

        $entries = $line->events()
            ->when($from, fn ($q) => $q->where('occurred_at', '>=', $from))
            ->when($to, fn ($q) => $q->where('occurred_at', '<=', $to))
            ->get()
            ->map(fn (PayrollLineEvent $e) => $this->entry($e, $currency))
            ->all();

        $current = $line->currentValue();
        $closing = $entries !== [] ? $entries[array_key_last($entries)]->runningTotal : ($opening ?? Money::zero($currency));

        return new AuditSection((string) $line->id, Period::parse($line->getAttribute('period')), $opening, $entries, $closing, $line->systemValue(), $current, $line->isAdjusted());
    }

    private function entry(PayrollLineEvent $e, string $currency): AuditEntry
    {
        $isCalc = $e->getAttribute('kind') === PayrollLineEvent::CALCULATION;

        return new AuditEntry(
            $e->getAttribute('event_no'),
            $isCalc ? ($e->getAttribute('applied') ? AuditEntryType::SystemCalculated : AuditEntryType::SystemIgnored) : AuditEntryType::Adjustment,
            $e->getAttribute('occurred_at')->toDateTimeImmutable(),
            Money::parse((string) $e->getAttribute('amount'), $currency),
            Money::parse((string) $e->getAttribute('balance_after'), $currency),
            $e->getAttribute('comment'),
            $isCalc ? null : $e->getAttribute('actor'),
            $isCalc ? null : $e->getAttribute('sequence'),
        );
    }
}
