<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain;

/** Persistence port of the aggregate; the implementation loads and stores its event stream. */
interface EarningLineRepository
{
    public function find(EarningLineId $id): ?EarningLine;

    /** Appends the aggregate's new events; fails with ConcurrencyConflict if the stream moved on in the meantime. */
    public function save(EarningLine $line): void;
}
