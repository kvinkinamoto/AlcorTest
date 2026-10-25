<?php

declare(strict_types=1);

namespace App\Payroll\Audit;

enum AuditEntryType: string
{
    case SystemCalculated = 'system_calculated';
    case SystemIgnored = 'system_ignored';
    case Adjustment = 'adjustment';

    public function label(): string
    {
        return match ($this) {
            self::SystemCalculated => 'System value',
            self::SystemIgnored => 'System recalculation ignored',
            self::Adjustment => 'Adjustment',
        };
    }
}
