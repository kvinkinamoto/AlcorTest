<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel;

use DateTimeInterface;
use InvalidArgumentException;
use Stringable;

/** A payroll month, "YYYY-MM". */
final readonly class Period implements Stringable
{
    private function __construct(public string $value) {}

    public static function parse(string $value): self
    {
        if (!preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $value)) {
            throw new InvalidArgumentException("Invalid period '{$value}', expected YYYY-MM.");
        }

        return new self($value);
    }

    public static function of(DateTimeInterface $date): self
    {
        return new self($date->format('Y-m'));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
