<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Application;

/** Unit of work: everything inside run() (events appended + projections updated) commits or rolls back together. */
interface Transaction
{
    /**
     * @template T
     * @param callable(): T $work
     * @return T
     */
    public function run(callable $work): mixed;
}
