<?php

declare(strict_types=1);

namespace App\Payroll\Earning\Domain;

use App\Payroll\Earning\Domain\Exception\ActorRequired;
use Stringable;

/** Who made a correction (the payroll specialist). */
final readonly class Actor implements Stringable
{
    public string $name;

    public function __construct(string $name)
    {
        $name = trim($name);
        if ($name === '') {
            throw new ActorRequired();
        }
        $this->name = $name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
