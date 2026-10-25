<?php

namespace App\Nexus\Modules\PayrollLine\Models;

use App\Nexus\Modules\Employee\Models\Employee;
use App\Nexus\Modules\PayrollAudit\Models\PayrollLineEvent;
use App\Payroll\AuditTrailIsImmutable;
use App\Payroll\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LogicException;
use Nodex\Nexus\Attributes\Column;
use Nodex\Nexus\Attributes\Module;
use Nodex\Nexus\Attributes\Section;
use Nodex\Nexus\Attributes\TableAction;
use Nodex\Nexus\Attributes\TableFilter;
use Nodex\Nexus\Concerns\HasAttributeSchemaProperties;

/**
 * Base-salary line of one employee for one period. It is created and changed only by
 * App\Payroll\CalculatePayroll (the salary stub), never by hand; the current value is
 * derived from the audit log. Admin actions: recalculate (re-run the stub) and open the audit.
 */
#[Module(
    name: 'payrollLine',
    label: 'payrollLine::translate.index_title',
    icon: 'solar:calculator-bold',
    group: 'employee::translate.group_payroll',
    showInMenu: true,
    livewire: true,
)]
#[TableAction(name: 'create', label: 'Create', icon: 'plus', isMain: true, isActive: false)]
#[TableAction(name: 'recalculate', label: 'Recalculate', icon: 'play', isConfirm: true)]
#[TableAction(name: 'audit', label: 'Audit', icon: 'eye', isConfirm: false)]
#[TableAction(name: 'edit', label: 'Edit', icon: 'edit', isActive: false)]
#[TableAction(name: 'delete', label: 'Delete', icon: 'delete', isActive: false)]
#[TableFilter(name: 'search', label: 'Search by employee or period', type: 'search')]
#[Section(name: 'main', column: 'right', type: 'base', icon: 'solar:calculator-bold')]
class PayrollLine extends Model
{
    use HasAttributeSchemaProperties;

    /** Set by CalculatePayroll while it writes; any other writer is refused. */
    public static bool $systemWrite = false;

    protected $table = 'nx_payroll_lines';

    protected $fillable = ['employee_id', 'period', 'currency', 'label', 'system_value'];

    protected $casts = ['system_value' => 'decimal:2'];

    #[Column(label: 'Employee / period', sortable: true, searchable: true)]
    protected $label;

    #[Column(label: 'System value')]
    protected $system_value;

    #[Column(label: 'Current value')]
    protected $current_value;

    #[Column(label: 'Frozen')]
    protected $frozen;

    protected static function booted(): void
    {
        $guard = function () {
            if (! self::$systemWrite) {
                throw new LogicException('Payroll lines are created and changed only by the payroll calculation.');
            }
        };
        static::creating($guard);
        static::updating($guard);
        static::deleting(fn () => throw new AuditTrailIsImmutable());
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(PayrollLineEvent::class, 'payroll_line_id')->orderBy('event_no');
    }

    public function adjustments(): HasMany
    {
        return $this->events()->where('kind', PayrollLineEvent::ADJUSTMENT);
    }

    public function isAdjusted(): bool
    {
        return $this->adjustments()->exists();
    }

    public function systemValue(): Money
    {
        return Money::parse((string) $this->getAttribute('system_value'), $this->getAttribute('currency'));
    }

    /** The ledger balance after the latest event, which equals system value + adjustments. */
    public function currentValue(): Money
    {
        $balance = $this->events()->reorder('event_no', 'desc')->value('balance_after');

        return $balance === null ? $this->systemValue() : Money::parse((string) $balance, $this->getAttribute('currency'));
    }

    public function getCurrentValueAttribute(): string
    {
        return $this->currentValue()->format();
    }

    public function getFrozenAttribute(): string
    {
        return $this->isAdjusted() ? 'yes' : 'no';
    }
}
