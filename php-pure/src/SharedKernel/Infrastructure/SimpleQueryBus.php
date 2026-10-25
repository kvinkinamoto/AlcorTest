<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Infrastructure;

use Alcor\Payroll\SharedKernel\Application\QueryBus;
use LogicException;

final class SimpleQueryBus implements QueryBus
{
    /** @var array<class-string, callable> */
    private array $handlers = [];

    /** @param class-string $queryClass */
    public function register(string $queryClass, callable $handler): void
    {
        $this->handlers[$queryClass] = $handler;
    }

    public function ask(object $query): mixed
    {
        $handler = $this->handlers[$query::class] ?? throw new LogicException('No handler for query ' . $query::class);

        return $handler($query);
    }
}
