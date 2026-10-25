<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Application;

/** Read side entry point: one query object in, a read-model answer out. Never changes state. */
interface QueryBus
{
    public function ask(object $query): mixed;
}
