<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Application;

use Alcor\Payroll\SharedKernel\Domain\DomainEvent;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
