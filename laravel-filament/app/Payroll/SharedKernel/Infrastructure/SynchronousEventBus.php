<?php

declare(strict_types=1);

namespace App\Payroll\SharedKernel\Infrastructure;

use App\Payroll\SharedKernel\Application\EventBus;
use App\Payroll\SharedKernel\Domain\DomainEvent;

/** Calls subscribers immediately, in the caller's transaction, so projections are never behind the event store. */
final class SynchronousEventBus implements EventBus
{
    /** @var list<array{string, callable}> */
    private array $subscribers = [];

    /** @param class-string<DomainEvent>|'*' $eventClass */
    public function subscribe(string $eventClass, callable $subscriber): void
    {
        $this->subscribers[] = [$eventClass, $subscriber];
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            foreach ($this->subscribers as [$class, $subscriber]) {
                if ($class === '*' || $event instanceof $class) {
                    $subscriber($event);
                }
            }
        }
    }
}
