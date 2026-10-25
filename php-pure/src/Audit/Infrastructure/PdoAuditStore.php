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
use PDO;

/** MySQL projection (`line_view`, `audit_entry`) and read model. Rebuildable from the event store at any time. */
final readonly class PdoAuditStore implements AuditProjection, AuditReadModel
{
    private const FORMAT = 'Y-m-d H:i:s.u';

    public function __construct(private PDO $pdo, private string $prefix) {}

    public function reset(): void
    {
        $this->pdo->exec("DELETE FROM {$this->prefix}audit_entry");
        $this->pdo->exec("DELETE FROM {$this->prefix}line_view");
    }

    public function systemValueSet(EarningLineId $id, Money $value, DateTimeImmutable $at): void
    {
        $this->pdo->prepare(
            "INSERT INTO {$this->prefix}line_view (line_id, employee_id, period, currency, system_value_cents, current_value_cents, frozen, adjustment_count)
             VALUES (?, ?, ?, ?, ?, ?, 0, 0)
             ON DUPLICATE KEY UPDATE system_value_cents = VALUES(system_value_cents), current_value_cents = VALUES(current_value_cents)",
        )->execute([(string) $id, $id->employeeId, (string) $id->period, $value->currency, $value->cents, $value->cents]);

        $this->entry($id, AuditEntryType::SystemCalculated, $at, $value->cents, $value->cents, null, null, null);
    }

    public function recalculationIgnored(EarningLineId $id, Money $ignoredValue, DateTimeImmutable $at): void
    {
        $current = (int) $this->scalar("SELECT current_value_cents FROM {$this->prefix}line_view WHERE line_id = ?", [(string) $id]);

        $this->entry($id, AuditEntryType::SystemIgnored, $at, $ignoredValue->cents, $current, 'Line already has manual adjustments', null, null);
    }

    public function adjustmentAdded(EarningLineId $id, int $number, Money $amount, string $comment, string $actor, DateTimeImmutable $at): void
    {
        $this->pdo->prepare(
            "UPDATE {$this->prefix}line_view SET current_value_cents = current_value_cents + ?, frozen = 1, adjustment_count = ? WHERE line_id = ?",
        )->execute([$amount->cents, $number, (string) $id]);

        $current = (int) $this->scalar("SELECT current_value_cents FROM {$this->prefix}line_view WHERE line_id = ?", [(string) $id]);

        $this->entry($id, AuditEntryType::Adjustment, $at, $amount->cents, $current, $comment, $actor, $number);
    }

    public function line(string $employeeId, Period $period): ?LineView
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}line_view WHERE line_id = ?");
        $stmt->execute(["{$employeeId}:{$period}"]);
        $row = $stmt->fetch();

        return $row ? $this->lineFrom($row) : null;
    }

    public function linesOf(string $employeeId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}line_view WHERE employee_id = ? ORDER BY period");
        $stmt->execute([$employeeId]);

        return array_map($this->lineFrom(...), $stmt->fetchAll());
    }

    public function entriesOf(string $employeeId, Period $period): array
    {
        $currency = (string) $this->scalar("SELECT currency FROM {$this->prefix}line_view WHERE line_id = ?", ["{$employeeId}:{$period}"]);
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->prefix}audit_entry WHERE line_id = ? ORDER BY event_no");
        $stmt->execute(["{$employeeId}:{$period}"]);

        return array_map(static fn (array $r) => new AuditEntry(
            (int) $r['event_no'],
            AuditEntryType::from($r['type']),
            new DateTimeImmutable($r['occurred_at']),
            Money::cents((int) $r['amount_cents'], $currency),
            Money::cents((int) $r['balance_cents'], $currency),
            $r['comment'],
            $r['actor'],
            $r['adjustment_no'] === null ? null : (int) $r['adjustment_no'],
        ), $stmt->fetchAll());
    }

    private function entry(EarningLineId $id, AuditEntryType $type, DateTimeImmutable $at, int $amount, int $balance, ?string $comment, ?string $actor, ?int $adjustmentNo): void
    {
        $eventNo = (int) $this->scalar("SELECT COALESCE(MAX(event_no), 0) + 1 FROM {$this->prefix}audit_entry WHERE line_id = ?", [(string) $id]);

        $this->pdo->prepare(
            "INSERT INTO {$this->prefix}audit_entry (line_id, event_no, type, amount_cents, balance_cents, comment, actor, adjustment_no, occurred_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
        )->execute([(string) $id, $eventNo, $type->value, $amount, $balance, $comment, $actor, $adjustmentNo, $at->format(self::FORMAT)]);
    }

    /** @param array<string, mixed> $row */
    private function lineFrom(array $row): LineView
    {
        $currency = $row['currency'];

        return new LineView(
            $row['employee_id'],
            Period::parse($row['period']),
            Money::cents((int) $row['system_value_cents'], $currency),
            Money::cents((int) $row['current_value_cents'], $currency),
            (bool) $row['frozen'],
            (int) $row['adjustment_count'],
        );
    }

    /** @param list<mixed> $params */
    private function scalar(string $sql, array $params): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }
}
