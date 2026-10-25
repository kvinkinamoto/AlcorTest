<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain\Exception;

use Alcor\Payroll\SharedKernel\Domain\DomainRuleViolation;

final class CommentRequired extends DomainRuleViolation
{
    public function __construct()
    {
        parent::__construct('An adjustment requires a comment.');
    }
}
