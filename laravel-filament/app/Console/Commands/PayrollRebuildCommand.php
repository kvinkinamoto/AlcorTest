<?php

namespace App\Console\Commands;

use App\Payroll\Audit\Application\RebuildAuditProjection;
use Illuminate\Console\Command;

/** payroll:rebuild — drops the Audit read model and replays every stored event into it. */
class PayrollRebuildCommand extends Command
{
    protected $signature = 'payroll:rebuild';

    protected $description = 'Rebuild the audit read model from the event store';

    public function handle(RebuildAuditProjection $rebuild): int
    {
        $this->info("Replayed {$rebuild()} events.");

        return self::SUCCESS;
    }
}
