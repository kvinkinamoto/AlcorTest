<?php

namespace App\Payroll\Audit\Application;

use App\Payroll\SharedKernel\Application\EventStore;
use App\Payroll\SharedKernel\Application\Transaction;

/** Throws the Audit read model away and rebuilds it by replaying every stored event. */
final readonly class RebuildAuditProjection
{
    public function __construct(
        private EventStore $store,
        private AuditProjection $projection,
        private AuditProjector $projector,
        private Transaction $transaction,
    ) {}

    /** @return int number of events replayed */
    public function __invoke(): int
    {
        return $this->transaction->run(function (): int {
            $this->projection->reset();

            $count = 0;
            foreach ($this->store->all() as $event) {
                ($this->projector)($event);
                $count++;
            }

            return $count;
        });
    }
}
