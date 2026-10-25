<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Domain;

use DomainException;

/** Base of every business-rule failure raised by an aggregate or value object. */
class DomainRuleViolation extends DomainException {}
