<?php

namespace App\Payroll;

use App\Nexus\Modules\PayrollAdjustment\Models\PayrollAdjustment;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use Illuminate\Support\Facades\DB;

/** Programmatic/CLI entry for adding an adjustment (the admin form goes through the same model). */
class AdjustPayrollLine
{
    /** Re-sending the same idempotency key returns the adjustment saved the first time. */
    public function __invoke(PayrollLine $line, string $amount, string $comment, string $actor, ?string $idempotencyKey = null): PayrollAdjustment
    {
        return DB::transaction(function () use ($line, $amount, $comment, $actor, $idempotencyKey) {
            $line = PayrollLine::query()->whereKey($line->getKey())->lockForUpdate()->firstOrFail();

            if ($idempotencyKey !== null) {
                $existing = PayrollAdjustment::query()->where('payroll_line_id', $line->id)->where('idempotency_key', $idempotencyKey)->first();
                if ($existing) {
                    return $existing;
                }
            }

            return PayrollAdjustment::create([
                'payroll_line_id' => $line->id,
                'amount' => Money::parse($amount, $line->getAttribute('currency'))->toDecimal(),
                'comment' => $comment,
                'actor' => $actor,
                'idempotency_key' => $idempotencyKey,
            ]);
        });
    }
}
