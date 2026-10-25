<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Infrastructure;

use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use DateTimeImmutable;
use InvalidArgumentException;
use ReflectionClass;

/** Maps stored event type names to classes (and back) so streams can be rebuilt from JSON. */
final class EventRegistry
{
    /** @var array<string, class-string<DomainEvent>> */
    private array $classes = [];

    /** @param list<class-string<DomainEvent>> $events */
    public function __construct(array $events)
    {
        foreach ($events as $class) {
            $this->classes[(new ReflectionClass($class))->getShortName()] = $class;
        }
    }

    public function typeOf(DomainEvent $event): string
    {
        return (new ReflectionClass($event))->getShortName();
    }

    /** @param array<string, mixed> $payload */
    public function rebuild(string $type, array $payload, DateTimeImmutable $occurredAt): DomainEvent
    {
        $class = $this->classes[$type] ?? throw new InvalidArgumentException("Unknown event type '{$type}'.");

        return $class::fromPayload($payload, $occurredAt);
    }
}
