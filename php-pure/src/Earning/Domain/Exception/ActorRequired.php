<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain\Exception;

use Alcor\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class ActorRequired extends DomainRuleViolation
{
    public function __construct()
    {
        parent::__construct('An adjustment requires an actor.');
    }
}
