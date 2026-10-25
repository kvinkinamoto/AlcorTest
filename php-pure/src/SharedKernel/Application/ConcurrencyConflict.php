<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Application;

use RuntimeException;

/** Two writers changed the same aggregate at once; the second one must reload and decide again. */
final class ConcurrencyConflict extends RuntimeException
{
    public static function forStream(string $streamId, int $expectedVersion): self
    {
        return new self("Stream '{$streamId}' is no longer at version {$expectedVersion}; reload it and retry.");
    }
}
