<?php

namespace App\Models;

use App\Payroll\SharedKernel\Money;
use Illuminate\Database\Eloquent\Model;

/**
 * Read model of an earning line (table `payroll_line_views`, maintained by the Audit projector).
 * Display only: lines change exclusively through the CalculateEarningLine / AddAdjustment commands.
 */
class PayrollLine extends Model
{
    protected $table = 'payroll_line_views';

    protected $primaryKey = 'line_id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $casts = ['frozen' => 'boolean'];

    public function systemValue(): Money
    {
        return Money::cents((int) $this->system_value_cents, $this->currency);
    }

    public function currentValue(): Money
    {
        return Money::cents((int) $this->current_value_cents, $this->currency);
    }
}
