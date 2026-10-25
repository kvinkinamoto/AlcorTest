<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain;

/** What an automatic calculation did to the line. */
enum CalculationOutcome: string
{
    case Created = 'created';
    case Recalculated = 'recalculated';
    case Ignored = 'ignored';
}
