<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel\Infrastructure;

use Alcor\Payroll\SharedKernel\Application\ConcurrencyConflict;
use Alcor\Payroll\SharedKernel\Application\EventStore;
use Alcor\Payroll\SharedKernel\Domain\DomainEvent;
use DateTimeImmutable;
use PDO;
use PDOException;

/**
 * MySQL event store. `(stream_id, version)` is unique, so two concurrent appends to the same
 * stream cannot both succeed; triggers (see MySqlSchema) refuse UPDATE and DELETE.
 */
final readonly class PdoEventStore implements EventStore
{
    private const FORMAT = 'Y-m-d H:i:s.u';

    public function __construct(private PDO $pdo, private EventRegistry $registry, private string $prefix) {}

    public function append(string $streamId, int $expectedVersion, array $events): void
    {
        $insert = $this->pdo->prepare(
            "INSERT INTO {$this->prefix}events (stream_id, version, event_type, payload, occurred_at) VALUES (?, ?, ?, ?, ?)",
        );

        try {
            foreach ($events as $i => $event) {
                $insert->execute([
                    $streamId,
                    $expectedVersion + $i + 1,
                    $this->registry->typeOf($event),
                    json_encode($event->toPayload(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    $event->occurredAt()->format(self::FORMAT),
                ]);
            }
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // duplicate (stream_id, version)
                throw ConcurrencyConflict::forStream($streamId, $expectedVersion);
            }
            throw $e;
        }
    }

    public function load(string $streamId): array
    {
        $rows = $this->pdo->prepare("SELECT event_type, payload, occurred_at FROM {$this->prefix}events WHERE stream_id = ? ORDER BY version");
        $rows->execute([$streamId]);

        return array_map($this->hydrate(...), $rows->fetchAll());
    }

    public function all(): iterable
    {
        $rows = $this->pdo->query("SELECT event_type, payload, occurred_at FROM {$this->prefix}events ORDER BY id");

        foreach ($rows as $row) {
            yield $this->hydrate($row);
        }
    }

    /** @param array<string, string> $row */
    private function hydrate(array $row): DomainEvent
    {
        return $this->registry->rebuild(
            $row['event_type'],
            json_decode($row['payload'], true, 512, JSON_THROW_ON_ERROR),
            new DateTimeImmutable($row['occurred_at']),
        );
    }
}
