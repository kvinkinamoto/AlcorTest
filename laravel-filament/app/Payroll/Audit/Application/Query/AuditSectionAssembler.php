<?php

declare(strict_types=1);

namespace App\Payroll\Audit\Application\Query;

use App\Payroll\Audit\Application\ReadModel\AuditEntry;
use App\Payroll\Audit\Application\ReadModel\AuditSection;
use App\Payroll\Audit\Application\ReadModel\LineView;
use App\Payroll\SharedKernel\Money;
use DateTimeImmutable;

/** Applies the date window to a line's history; entries before the window collapse into the opening balance. */
final class AuditSectionAssembler
{
    /** @param list<AuditEntry> $entries the whole history of the line, oldest first */
    public function assemble(LineView $line, array $entries, ?DateTimeImmutable $from, ?DateTimeImmutable $to): AuditSection
    {
        $opening = null;
        $inWindow = [];

        foreach ($entries as $entry) {
            if ($from !== null && $entry->at < $from) {
                $opening = $entry->runningTotal;
            } elseif ($to === null || $entry->at <= $to) {
                $inWindow[] = $entry;
            }
        }

        $closing = $inWindow !== [] ? $inWindow[array_key_last($inWindow)]->runningTotal : ($opening ?? Money::zero($line->systemValue->currency));

        return new AuditSection($line->id(), $line->period, $opening, $inWindow, $closing, $line->systemValue, $line->currentValue, $line->frozen);
    }
}
