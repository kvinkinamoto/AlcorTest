<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain;

use InvalidArgumentException;
use Stringable;

/** Client-chosen key that makes re-sending the same correction harmless (double click, retry). */
final readonly class IdempotencyKey implements Stringable
{
    public function __construct(public string $value)
    {
        if ($value === '' || strlen($value) > 100) {
            throw new InvalidArgumentException('An idempotency key is 1-100 characters.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
