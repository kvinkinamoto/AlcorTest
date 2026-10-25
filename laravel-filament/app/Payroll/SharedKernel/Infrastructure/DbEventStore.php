<?php

namespace App\Payroll\SharedKernel\Infrastructure;

use App\Payroll\SharedKernel\Application\ConcurrencyConflict;
use App\Payroll\SharedKernel\Application\EventStore;
use App\Payroll\SharedKernel\Domain\DomainEvent;
use DateTimeImmutable;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

/**
 * Database event store (`payroll_events`). `(stream_id, version)` is unique, so two concurrent appends to the
 * same stream cannot both succeed; on MySQL, triggers refuse UPDATE and DELETE.
 */
final readonly class DbEventStore implements EventStore
{
    private const FORMAT = 'Y-m-d H:i:s.u';

    public function __construct(private EventRegistry $registry) {}

    public function append(string $streamId, int $expectedVersion, array $events): void
    {
        try {
            foreach ($events as $i => $event) {
                DB::table('payroll_events')->insert([
                    'stream_id' => $streamId,
                    'version' => $expectedVersion + $i + 1,
                    'event_type' => $this->registry->typeOf($event),
                    'payload' => json_encode($event->toPayload(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                    'occurred_at' => $event->occurredAt()->format(self::FORMAT),
                ]);
            }
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // duplicate (stream_id, version)
                throw ConcurrencyConflict::forStream($streamId, $expectedVersion);
            }
            throw $e;
        }
    }

    public function load(string $streamId): array
    {
        return DB::table('payroll_events')->where('stream_id', $streamId)->orderBy('version')->get()
            ->map($this->hydrate(...))->all();
    }

    public function all(): iterable
    {
        foreach (DB::table('payroll_events')->orderBy('id')->cursor() as $row) {
            yield $this->hydrate($row);
        }
    }

    private function hydrate(object $row): DomainEvent
    {
        return $this->registry->rebuild(
            $row->event_type,
            json_decode($row->payload, true, 512, JSON_THROW_ON_ERROR),
            new DateTimeImmutable($row->occurred_at),
        );
    }
}
