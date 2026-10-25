<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Application;

use App\Payroll\SharedKernel\Domain\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
