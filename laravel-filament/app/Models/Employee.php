<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Read model of the Workforce context for the admin panel: it only displays the `employees` table.
 * Every change goes through the HireEmployee / ChangeSourceData commands, never through save().
 */
class Employee extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public function payrollLines(): HasMany
    {
        return $this->hasMany(PayrollLine::class, 'employee_id')->orderBy('period');
    }
}
