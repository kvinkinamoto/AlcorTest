<?php

namespace App\Nexus\Modules\Employee\Models;

use App\Nexus\Modules\Employee\Enums\PayrollCurrency;
use App\Nexus\Modules\Employee\Requests\AdminStoreRequest;
use App\Nexus\Modules\Employee\Requests\AdminUpdateRequest;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\AuditTrailIsImmutable;
use App\Payroll\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nodex\Nexus\Attributes\Column;
use Nodex\Nexus\Attributes\Field;
use Nodex\Nexus\Attributes\Module;
use Nodex\Nexus\Attributes\Requests;
use Nodex\Nexus\Attributes\Section;
use Nodex\Nexus\Attributes\TableAction;
use Nodex\Nexus\Attributes\TableFilter;
use Nodex\Nexus\Concerns\HasAttributeSchemaProperties;

/** An employee plus the salary source data the (stub) calculation reads. */
#[Module(
    name: 'employee',
    label: 'employee::translate.index_title',
    icon: 'solar:users-group-rounded-bold',
    group: 'employee::translate.group_payroll',
    showInMenu: true,
    livewire: true,
)]
#[TableAction(name: 'edit', label: 'Edit', icon: 'edit', isConfirm: false)]
#[TableAction(name: 'calculate', label: 'Calculate payroll', icon: 'play', isConfirm: false)]
#[TableAction(name: 'delete', label: 'Delete', icon: 'delete', isActive: false)]
#[TableFilter(name: 'search', label: 'Search by name', type: 'search')]
#[Requests(actions: ['store' => AdminStoreRequest::class, 'update' => AdminUpdateRequest::class])]
#[Section(name: 'general', column: 'left', type: 'base', icon: 'solar:user-bold')]
#[Section(name: 'source', column: 'right', type: 'base', icon: 'solar:wallet-money-bold')]
class Employee extends Model
{
    use HasAttributeSchemaProperties;

    protected $table = 'nx_employees';

    protected $fillable = ['name', 'currency', 'base_salary', 'benefits_deduction', 'bonus'];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'benefits_deduction' => 'decimal:2',
        'bonus' => 'decimal:2',
    ];

    #[Column(label: 'Name', sortable: true, searchable: true)]
    #[Field(type: 'string', section: 'general', label: 'Name', required: true, rules: ['max:255'])]
    protected $name;

    #[Column(label: 'Currency')]
    #[Field(type: 'enum', section: 'general', label: 'Currency', required: true, enum: PayrollCurrency::class, default: 'USD')]
    protected $currency;

    #[Column(label: 'Base salary')]
    #[Field(type: 'number', section: 'source', label: 'Base salary', required: true, default: 0)]
    protected $base_salary;

    #[Column(label: 'Benefits deduction')]
    #[Field(type: 'number', section: 'source', label: 'Benefits deduction', required: false, default: 0)]
    protected $benefits_deduction;

    #[Column(label: 'Bonus')]
    #[Field(type: 'number', section: 'source', label: 'Bonus', required: false, default: 0)]
    protected $bonus;

    protected static function booted(): void
    {
        // Existing lines are in the old currency; changing it would make their history inconsistent.
        static::updating(function (self $employee) {
            if ($employee->isDirty('currency') && $employee->payrollLines()->exists()) {
                throw new AuditTrailIsImmutable('The currency cannot change once payroll lines exist.');
            }
        });

        // An employee with payroll history is part of the audit trail.
        static::deleting(function (self $employee) {
            if ($employee->payrollLines()->exists()) {
                throw new AuditTrailIsImmutable();
            }
        });
    }

    public function payrollLines(): HasMany
    {
        return $this->hasMany(PayrollLine::class, 'employee_id')->orderBy('period');
    }

    public function money(string $attribute): Money
    {
        // getAttribute(): the Column/Field marker properties above shadow plain property access in class scope.
        return Money::parse((string) ($this->getAttribute($attribute) ?? '0'), $this->getAttribute('currency'));
    }
}
