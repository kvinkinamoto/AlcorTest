<?php

namespace App\Payroll\SharedKernel\Infrastructure;

use App\Payroll\SharedKernel\Application\Transaction;
use Illuminate\Support\Facades\DB;

/** Events appended and projections updated inside run() commit or roll back together (nested calls join). */
final class DbTransaction implements Transaction
{
    public function run(callable $work): mixed
    {
        return DB::transaction($work);
    }
}
