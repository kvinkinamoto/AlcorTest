<?php

namespace App\Payroll\SharedKernel\Infrastructure;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/** The application clock; follows Carbon's test time (travelTo) so scenarios can be replayed on chosen days. */
final class LaravelClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return now()->toDateTimeImmutable();
    }
}
