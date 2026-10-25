<?php

namespace App\Nexus\Modules\PayrollAdjustment\Models;

use App\Nexus\Modules\PayrollAdjustment\Requests\AdminStoreRequest;
use App\Nexus\Modules\PayrollAdjustment\Requests\AdminUpdateRequest;
use App\Nexus\Modules\PayrollAudit\Models\PayrollLineEvent;
use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nodex\Nexus\Attributes\Column;
use Nodex\Nexus\Attributes\Field;
use Nodex\Nexus\Attributes\Module;
use Nodex\Nexus\Attributes\Relation;
use Nodex\Nexus\Attributes\Requests;
use Nodex\Nexus\Attributes\Section;
use Nodex\Nexus\Attributes\TableAction;
use Nodex\Nexus\Attributes\TableFilter;

/**
 * Manual adjustments: the `kind = adjustment` slice of the audit log with an entry form.
 * Append-only (edit and delete are disabled and the parent model refuses them anyway).
 * The author is the logged-in admin; numbering, balance and locking come from PayrollLineEvent.
 */
#[Module(
    name: 'payrollAdjustment',
    label: 'payrollAdjustment::translate.index_title',
    icon: 'solar:pen-new-square-bold',
    group: 'employee::translate.group_payroll',
    showInMenu: true,
    livewire: true,
)]
#[TableAction(name: 'edit', label: 'Edit', icon: 'edit', isActive: false)]
#[TableAction(name: 'delete', label: 'Delete', icon: 'delete', isActive: false)]
#[TableFilter(name: 'search', label: 'Search by comment or author', type: 'search')]
#[Requests(actions: ['store' => AdminStoreRequest::class, 'update' => AdminUpdateRequest::class])]
#[Section(name: 'main', column: 'right', type: 'base', icon: 'solar:pen-new-square-bold')]
class PayrollAdjustment extends PayrollLineEvent
{
    protected $attributes = ['kind' => self::ADJUSTMENT];

    protected $with = ['line'];

    protected $fillable = ['payroll_line_id', 'amount', 'comment', 'actor', 'idempotency_key'];

    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope('adjustments', fn (Builder $q) => $q->where('kind', self::ADJUSTMENT));
    }

    #[Field(type: 'relation', section: 'main', label: 'Payroll line', required: true)]
    #[Relation(type: 'belongsTo', show: 'label', ajax: true, ajaxMode: 'load')]
    public function line(): BelongsTo
    {
        return $this->belongsTo(PayrollLine::class, 'payroll_line_id');
    }

    #[Column(label: 'Line', sortable: false)]
    protected $line_label;

    #[Column(label: '#', sortable: true)]
    protected $sequence;

    #[Column(label: 'Amount', sortable: true)]
    #[Field(type: 'number', section: 'main', label: 'Amount (+ or −)', required: true)]
    protected $amount;

    #[Column(label: 'Comment', searchable: true)]
    #[Field(type: 'text', section: 'main', label: 'Comment', required: true)]
    protected $comment;

    #[Column(label: 'By', searchable: true)]
    protected $actor;

    public function getLineLabelAttribute(): string
    {
        return (string) $this->line?->getAttribute('label');
    }
}
