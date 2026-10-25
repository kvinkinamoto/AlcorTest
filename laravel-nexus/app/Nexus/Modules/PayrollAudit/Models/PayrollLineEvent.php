<?php

namespace App\Nexus\Modules\PayrollAudit\Models;

use App\Nexus\Modules\PayrollLine\Models\PayrollLine;
use App\Payroll\AuditTrailIsImmutable;
use App\Payroll\Events\ManualAdjustmentAdded;
use App\Payroll\Money;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;
use Nodex\Nexus\Attributes\Column;
use Nodex\Nexus\Attributes\Module;
use Nodex\Nexus\Attributes\Section;
use Nodex\Nexus\Attributes\TableAction;
use Nodex\Nexus\Concerns\HasAttributeSchemaProperties;

/**
 * One audit-log row, written ledger style: it carries its own number and the line balance
 * after it. Append-only: updates and deletes are refused here and by MySQL triggers.
 * The module's admin index is the audit report (see Http/Controllers/AdminController).
 */
#[Module(
    name: 'payrollAudit',
    label: 'payrollAudit::translate.index_title',
    icon: 'solar:clipboard-list-bold',
    group: 'employee::translate.group_payroll',
    showInMenu: true,
    livewire: true,
)]
#[TableAction(name: 'create', label: 'Create', icon: 'plus', isMain: true, isActive: false)]
#[TableAction(name: 'edit', label: 'Edit', icon: 'edit', isActive: false)]
#[TableAction(name: 'delete', label: 'Delete', icon: 'delete', isActive: false)]
#[Section(name: 'main', column: 'right', type: 'base', icon: 'solar:clipboard-list-bold')]
class PayrollLineEvent extends Model
{
    use HasAttributeSchemaProperties;

    public const CALCULATION = 'calculation';
    public const ADJUSTMENT = 'adjustment';

    public $timestamps = false;

    protected $table = 'nx_payroll_line_events';

    protected $fillable = ['payroll_line_id', 'kind', 'amount', 'applied', 'comment', 'actor', 'idempotency_key', 'occurred_at'];

    protected $casts = [
        'applied' => 'boolean',
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'occurred_at' => 'datetime',
    ];

    #[Column(label: 'Date')]
    protected $occurred_at;

    #[Column(label: 'Amount')]
    protected $amount;

    #[Column(label: 'Balance')]
    protected $balance_after;

    #[Column(label: 'Comment')]
    protected $comment;

    protected static function booted(): void
    {
        // Note: attributes are read/written with getAttribute()/setAttribute() because the Column/Field
        // marker properties declared on these classes would otherwise shadow them inside class scope.
        static::creating(function (self $event) {
            // The caller runs inside a transaction (see save()), so this lock serialises writers per line.
            $line = PayrollLine::query()->whereKey($event->getAttribute('payroll_line_id'))->lockForUpdate()->firstOrFail();
            $last = PayrollLineEvent::query()->where('payroll_line_id', $line->id)->orderByDesc('event_no')->first(['event_no', 'balance_after']);

            $event->setAttribute('event_no', ($last?->getAttribute('event_no') ?? 0) + 1);
            $event->setAttribute('occurred_at', $event->getAttribute('occurred_at') ?? now());
            $amount = Money::parse((string) $event->getAttribute('amount'), $line->currency);
            $previous = $last ? Money::parse((string) $last->getAttribute('balance_after'), $line->currency) : null;

            if ($event->getAttribute('kind') === self::CALCULATION) {
                $balance = $event->getAttribute('applied') ? $amount : $previous;
                $event->setAttribute('balance_after', $balance->toDecimal());

                return;
            }

            $comment = trim((string) $event->getAttribute('comment'));
            $actor = trim((string) ($event->getAttribute('actor') ?? auth()->user()?->name ?? ''));
            if ($comment === '') {
                throw new InvalidArgumentException('An adjustment requires a comment.');
            }
            if ($actor === '') {
                throw new InvalidArgumentException('An adjustment requires an actor.');
            }
            if ($amount->isZero()) {
                throw new InvalidArgumentException('An adjustment amount must not be zero.');
            }
            if ($previous === null) {
                throw new InvalidArgumentException('The line has not been calculated yet.');
            }

            $event->setAttribute('comment', $comment);
            $event->setAttribute('actor', $actor);
            $event->setAttribute('sequence', PayrollLineEvent::query()->where('payroll_line_id', $line->id)->where('kind', self::ADJUSTMENT)->count() + 1);
            $event->setAttribute('balance_after', $previous->plus($amount)->toDecimal());
        });

        // Raised here so the admin form and the CLI/programmatic path announce adjustments the same way.
        static::created(function (self $event) {
            if ($event->getAttribute('kind') === self::ADJUSTMENT) {
                event(new ManualAdjustmentAdded(
                    (int) $event->getAttribute('payroll_line_id'),
                    (int) $event->getAttribute('sequence'),
                    (string) $event->getAttribute('amount'),
                    (string) $event->getAttribute('comment'),
                    (string) $event->getAttribute('actor'),
                ));
            }
        });

        static::updating(fn () => throw new AuditTrailIsImmutable());
        static::deleting(fn () => throw new AuditTrailIsImmutable());
    }

    /** Every insert runs in a transaction so the line lock taken in `creating` is held until commit. */
    public function save(array $options = []): bool
    {
        return DB::transaction(fn () => parent::save($options));
    }

    public function line(): BelongsTo
    {
        return $this->belongsTo(PayrollLine::class, 'payroll_line_id');
    }
}
