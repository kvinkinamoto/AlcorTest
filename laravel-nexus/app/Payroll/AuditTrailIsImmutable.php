<?php

namespace App\Payroll;

use LogicException;

final class AuditTrailIsImmutable extends LogicException
{
    public function __construct(string $message = 'Saved audit entries cannot be edited or deleted; add a compensating adjustment instead.')
    {
        parent::__construct($message);
    }
}
