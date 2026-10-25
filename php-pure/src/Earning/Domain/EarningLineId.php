<?php

declare(strict_types=1);

namespace Alcor\Payroll\Earning\Domain;

use Alcor\Payroll\SharedKernel\Period;
use InvalidArgumentException;
use Stringable;

/** Identity of an earning line: one employee in one payroll month. Also the name of its event stream. */
final readonly class EarningLineId implements Stringable
{
    public function __construct(public string $employeeId, public Period $period)
    {
        if (trim($employeeId) === '') {
            throw new InvalidArgumentException('An earning line needs an employee id.');
        }
    }

    public static function fromString(string $value): self
    {
        [$employeeId, $period] = explode(':', $value, 2) + [1 => ''];

        return new self($employeeId, Period::parse($period));
    }

    public function __toString(): string
    {
        return "{$this->employeeId}:{$this->period}";
    }
}
