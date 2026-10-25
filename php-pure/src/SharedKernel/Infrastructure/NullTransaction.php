<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Infrastructure;

use Alcor\Payroll\SharedKernel\Application\Transaction;

final class NullTransaction implements Transaction
{
    public function run(callable $work): mixed
    {
        return $work();
    }
}
