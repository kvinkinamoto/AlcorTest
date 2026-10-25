<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Application;

/** Write side entry point: one command object in, one handler runs. */
interface CommandBus
{
    public function dispatch(object $command): mixed;
}
