<?php

declare(strict_types=1);

namespace Alcor\Payroll;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/** Every call to now() is one day after the previous one; used to seed demo data with a believable history. */
final class SteppingClock implements ClockInterface
{
    private DateTimeImmutable $current;

    public function __construct(string $start = '2026-01-01 09:00:00')
    {
        $this->current = new DateTimeImmutable($start);
    }

    public function now(): DateTimeImmutable
    {
        $now = $this->current;
        $this->current = $this->current->modify('+1 day');

        return $now;
    }
}
