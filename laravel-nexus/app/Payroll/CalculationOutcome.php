<?php

namespace App\Payroll;

enum CalculationOutcome: string
{
    case Created = 'created';
    case Recalculated = 'recalculated';
    /** The line has manual adjustments, so the result was only logged. */
    case Ignored = 'ignored';
}
