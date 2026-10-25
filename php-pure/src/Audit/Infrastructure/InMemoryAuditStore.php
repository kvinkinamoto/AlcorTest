<?php

declare(strict_types=1);

namespace Alcor\Payroll\Audit\Infrastructure;

use Alcor\Payroll\Audit\Application\AuditProjection;
use Alcor\Payroll\Audit\Application\AuditReadModel;
use Alcor\Payroll\Audit\Application\ReadModel\AuditEntry;
use Alcor\Payroll\Audit\Application\ReadModel\AuditEntryType;
use Alcor\Payroll\Audit\Application\ReadModel\LineView;
use Alcor\Payroll\Earning\Domain\EarningLineId;
use Alcor\Payroll\SharedKernel\Money;
use Alcor\Payroll\SharedKernel\Period;
use DateTimeImmutable;

/** In-memory projection and read model in one object (tests and the in-memory scenario). */
final class InMemoryAuditStore implements AuditProjection, AuditReadModel
{
    /** @var array<string, LineView> */
    private array $lines = [];

    /** @var array<string, list<AuditEntry>> */
    private array $entries = [];

    public function reset(): void
    {
        $this->lines = [];
        $this->entries = [];
    }

    public function systemValueSet(EarningLineId $id, Money $value, DateTimeImmutable $at): void
    {
        $key = (string) $id;
        $this->lines[$key] = new LineView($id->employeeId, $id->period, $value, $value, false, 0);
        $this->entries[$key][] = new AuditEntry(count($this->entries[$key] ?? []) + 1, AuditEntryType::SystemCalculated, $at, $value, $value, null, null);
    }

    public function recalculationIgnored(EarningLineId $id, Money $ignoredValue, DateTimeImmutable $at): void
    {
        $key = (string) $id;
        $this->entries[$key][] = new AuditEntry(
            count($this->entries[$key]) + 1,
            AuditEntryType::SystemIgnored,
            $at,
            $ignoredValue,
            $this->lines[$key]->currentValue,
            'Line already has manual adjustments',
            null,
        );
    }

    public function adjustmentAdded(EarningLineId $id, int $number, Money $amount, string $comment, string $actor, DateTimeImmutable $at): void
    {
        $key = (string) $id;
        $line = $this->lines[$key];
        $current = $line->currentValue->plus($amount);
        $this->lines[$key] = new LineView($line->employeeId, $line->period, $line->systemValue, $current, true, $number);
        $this->entries[$key][] = new AuditEntry(count($this->entries[$key]) + 1, AuditEntryType::Adjustment, $at, $amount, $current, $comment, $actor, $number);
    }

    public function line(string $employeeId, Period $period): ?LineView
    {
        return $this->lines["{$employeeId}:{$period}"] ?? null;
    }

    public function linesOf(string $employeeId): array
    {
        $lines = array_values(array_filter($this->lines, static fn (LineView $l) => $l->employeeId === $employeeId));
        usort($lines, static fn (LineView $a, LineView $b) => (string) $a->period <=> (string) $b->period);

        return $lines;
    }

    public function entriesOf(string $employeeId, Period $period): array
    {
        return $this->entries["{$employeeId}:{$period}"] ?? [];
    }
}
