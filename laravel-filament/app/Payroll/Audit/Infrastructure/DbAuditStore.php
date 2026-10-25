<?php

namespace App\Payroll\Audit\Infrastructure;

use App\Payroll\Audit\Application\AuditProjection;
use App\Payroll\Audit\Application\AuditReadModel;
use App\Payroll\Audit\Application\ReadModel\AuditEntry;
use App\Payroll\Audit\Application\ReadModel\AuditEntryType;
use App\Payroll\Audit\Application\ReadModel\LineView;
use App\Payroll\Earning\Domain\EarningLineId;
use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

/** Projection and read model in tables `payroll_line_views` and `payroll_audit_entries`; disposable, rebuilt from the event store. */
final class DbAuditStore implements AuditProjection, AuditReadModel
{
    private const FORMAT = 'Y-m-d H:i:s.u';

    public function reset(): void
    {
        DB::table('payroll_audit_entries')->delete();
        DB::table('payroll_line_views')->delete();
    }

    public function systemValueSet(EarningLineId $id, Money $value, DateTimeImmutable $at): void
    {
        DB::table('payroll_line_views')->upsert([[
            'line_id' => (string) $id,
            'employee_id' => $id->employeeId,
            'period' => (string) $id->period,
            'currency' => $value->currency,
            'system_value_cents' => $value->cents,
            'current_value_cents' => $value->cents,
            'frozen' => false,
            'adjustment_count' => 0,
        ]], ['line_id'], ['system_value_cents', 'current_value_cents']);

        $this->entry($id, AuditEntryType::SystemCalculated, $at, $value->cents, $value->cents, null, null, null);
    }

    public function recalculationIgnored(EarningLineId $id, Money $ignoredValue, DateTimeImmutable $at): void
    {
        $current = (int) DB::table('payroll_line_views')->where('line_id', (string) $id)->value('current_value_cents');

        $this->entry($id, AuditEntryType::SystemIgnored, $at, $ignoredValue->cents, $current, 'Line already has manual adjustments', null, null);
    }

    public function adjustmentAdded(EarningLineId $id, int $number, Money $amount, string $comment, string $actor, DateTimeImmutable $at): void
    {
        DB::table('payroll_line_views')->where('line_id', (string) $id)->update([
            'current_value_cents' => DB::raw('current_value_cents + ' . (int) $amount->cents),
            'frozen' => true,
            'adjustment_count' => $number,
        ]);
        $current = (int) DB::table('payroll_line_views')->where('line_id', (string) $id)->value('current_value_cents');

        $this->entry($id, AuditEntryType::Adjustment, $at, $amount->cents, $current, $comment, $actor, $number);
    }

    public function line(string $employeeId, Period $period): ?LineView
    {
        $row = DB::table('payroll_line_views')->where('line_id', "{$employeeId}:{$period}")->first();

        return $row ? $this->lineFrom($row) : null;
    }

    public function linesOf(string $employeeId): array
    {
        return DB::table('payroll_line_views')->where('employee_id', $employeeId)->orderBy('period')->get()
            ->map($this->lineFrom(...))->all();
    }

    public function entriesOf(string $employeeId, Period $period): array
    {
        $lineId = "{$employeeId}:{$period}";
        $currency = (string) DB::table('payroll_line_views')->where('line_id', $lineId)->value('currency');

        return DB::table('payroll_audit_entries')->where('line_id', $lineId)->orderBy('event_no')->get()
            ->map(fn (object $r) => new AuditEntry(
                (int) $r->event_no,
                AuditEntryType::from($r->type),
                new DateTimeImmutable($r->occurred_at),
                Money::cents((int) $r->amount_cents, $currency),
                Money::cents((int) $r->balance_cents, $currency),
                $r->comment,
                $r->actor,
                $r->adjustment_no === null ? null : (int) $r->adjustment_no,
            ))->all();
    }

    private function entry(EarningLineId $id, AuditEntryType $type, DateTimeImmutable $at, int $amount, int $balance, ?string $comment, ?string $actor, ?int $adjustmentNo): void
    {
        $eventNo = (int) DB::table('payroll_audit_entries')->where('line_id', (string) $id)->max('event_no') + 1;

        DB::table('payroll_audit_entries')->insert([
            'line_id' => (string) $id,
            'event_no' => $eventNo,
            'type' => $type->value,
            'amount_cents' => $amount,
            'balance_cents' => $balance,
            'comment' => $comment,
            'actor' => $actor,
            'adjustment_no' => $adjustmentNo,
            'occurred_at' => $at->format(self::FORMAT),
        ]);
    }

    private function lineFrom(object $row): LineView
    {
        return new LineView(
            $row->employee_id,
            Period::parse($row->period),
            Money::cents((int) $row->system_value_cents, $row->currency),
            Money::cents((int) $row->current_value_cents, $row->currency),
            (bool) $row->frozen,
            (int) $row->adjustment_count,
        );
    }
}
