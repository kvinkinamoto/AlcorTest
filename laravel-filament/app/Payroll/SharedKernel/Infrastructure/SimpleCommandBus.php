<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Infrastructure;

use App\Payroll\SharedKernel\Application\CommandBus;
use LogicException;

final class SimpleCommandBus implements CommandBus
{
    /** @var array<class-string, callable> */
    private array $handlers = [];

    /** @param class-string $commandClass */
    public function register(string $commandClass, callable $handler): void
    {
        $this->handlers[$commandClass] = $handler;
    }

    public function dispatch(object $command): mixed
    {
        $handler = $this->handlers[$command::class] ?? throw new LogicException('No handler for command ' . $command::class);

        return $handler($command);
    }
}
