<?php

declare(strict_types=1);

namespace Tests\Unit\Payroll;

use App\Payroll\Earning\Domain\Actor;
use App\Payroll\Earning\Domain\CalculationOutcome;
use App\Payroll\Earning\Domain\Comment;
use App\Payroll\Earning\Domain\EarningLine;
use App\Payroll\Earning\Domain\EarningLineId;
use App\Payroll\Earning\Domain\Event\AdjustmentAdded;
use App\Payroll\Earning\Domain\Event\LineCalculated;
use App\Payroll\Earning\Domain\Event\RecalculationIgnored;
use App\Payroll\Earning\Domain\Event\SystemValueRecalculated;
use App\Payroll\Earning\Domain\Exception\ActorRequired;
use App\Payroll\Earning\Domain\Exception\CommentRequired;
use App\Payroll\Earning\Domain\Exception\CurrencyMismatch;
use App\Payroll\Earning\Domain\Exception\LineNotCalculated;
use App\Payroll\Earning\Domain\Exception\ZeroAdjustment;
use App\Payroll\Earning\Domain\IdempotencyKey;
use App\Payroll\SharedKernel\Money;
use App\Payroll\SharedKernel\Period;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/** The aggregate on its own: decisions produce events, state is the events applied. */
final class EarningLineTest extends TestCase
{
    private EarningLine $line;
    private DateTimeImmutable $at;

    protected function setUp(): void
    {
        $this->line = EarningLine::start(new EarningLineId('anna', Period::parse('2026-01')));
        $this->at = new DateTimeImmutable('2026-01-10 09:00:00');
    }

    private function adjust(string $amount, string $comment = 'because', ?string $key = null): int
    {
        return $this->line->adjust(Money::parse($amount), new Comment($comment), new Actor('olena'), $this->at, $key === null ? null : new IdempotencyKey($key));
    }

    /** @return list<class-string> */
    private function recordedTypes(): array
    {
        return array_map(static fn ($e) => $e::class, $this->line->uncommittedEvents());
    }

    public function test_first_calculation_creates_the_line(): void
    {
        $this->assertSame(CalculationOutcome::Created, $this->line->calculate(Money::parse('1000'), $this->at));

        $this->assertSame([LineCalculated::class], $this->recordedTypes());
        $this->assertSame('$1,000.00', $this->line->currentValue()->format());
        $this->assertFalse($this->line->isFrozen());
    }

    public function test_recalculation_replaces_the_value_until_the_first_adjustment(): void
    {
        $this->line->calculate(Money::parse('1000'), $this->at);

        $this->assertSame(CalculationOutcome::Recalculated, $this->line->calculate(Money::parse('1050'), $this->at));
        $this->assertSame('$1,050.00', $this->line->currentValue()->format());
        $this->assertSame([LineCalculated::class, SystemValueRecalculated::class], $this->recordedTypes());
    }

    public function test_after_the_first_adjustment_the_line_is_frozen_and_recalculation_is_only_recorded(): void
    {
        $this->line->calculate(Money::parse('1050'), $this->at);
        $this->adjust('-45.55');

        $this->assertTrue($this->line->isFrozen());
        $this->assertSame(CalculationOutcome::Ignored, $this->line->calculate(Money::parse('2000'), $this->at));

        $this->assertSame('$1,050.00', $this->line->systemValue()->format(), 'the system value is frozen');
        $this->assertSame('$1,004.45', $this->line->currentValue()->format());
        $this->assertSame(RecalculationIgnored::class, $this->recordedTypes()[2]);
    }

    public function test_adjustments_are_numbered_and_add_up(): void
    {
        $this->line->calculate(Money::parse('1050'), $this->at);

        $this->assertSame([1, 2, 3], [$this->adjust('-45.55'), $this->adjust('100.10'), $this->adjust('-0.10')]);
        $this->assertSame('$1,104.45', $this->line->currentValue()->format());
    }

    public function test_the_same_idempotency_key_records_nothing_the_second_time(): void
    {
        $this->line->calculate(Money::parse('1000'), $this->at);

        $first = $this->adjust('-10', 'once', 'double-click');
        $before = count($this->line->uncommittedEvents());
        $second = $this->adjust('-10', 'once', 'double-click');

        $this->assertSame($first, $second);
        $this->assertCount($before, $this->line->uncommittedEvents());
        $this->assertSame('$990.00', $this->line->currentValue()->format());
    }

    public function test_state_is_rebuilt_from_history(): void
    {
        $this->line->calculate(Money::parse('1050'), $this->at);
        $this->adjust('-45.55', 'dental', 'k1');
        $this->line->calculate(Money::parse('2000'), $this->at);
        $this->adjust('100.10', 'overtime');

        $rebuilt = EarningLine::fromHistory($this->line->id, $this->line->uncommittedEvents());

        $this->assertSame('$1,104.55', $rebuilt->currentValue()->format());
        $this->assertSame('$1,050.00', $rebuilt->systemValue()->format());
        $this->assertTrue($rebuilt->isFrozen());
        $this->assertSame(2, $rebuilt->adjustmentCount());
        $this->assertSame([], $rebuilt->uncommittedEvents(), 'a replayed history raises nothing new');
        $this->assertSame(4, $rebuilt->committedVersion());
        $this->assertSame(1, $rebuilt->adjust(Money::parse('-45.55'), new Comment('dental'), new Actor('x'), $this->at, new IdempotencyKey('k1')), 'idempotency survives a rebuild');
    }

    public function test_an_adjustment_needs_a_calculated_line(): void
    {
        $this->expectException(LineNotCalculated::class);
        $this->adjust('-1');
    }

    public function test_comment_and_actor_are_mandatory_value_objects(): void
    {
        $this->assertThrows(CommentRequired::class, fn () => new Comment("  \n"));
        $this->assertThrows(ActorRequired::class, fn () => new Actor(''));
    }

    public function test_zero_adjustment_is_refused(): void
    {
        $this->line->calculate(Money::parse('1000'), $this->at);

        $this->expectException(ZeroAdjustment::class);
        $this->adjust('0');
    }

    public function test_currency_cannot_change_on_the_line(): void
    {
        $this->line->calculate(Money::parse('1000'), $this->at);

        $this->assertThrows(CurrencyMismatch::class, fn () => $this->line->adjust(Money::parse('5', 'EUR'), new Comment('x'), new Actor('a'), $this->at));
        $this->assertThrows(CurrencyMismatch::class, fn () => $this->line->calculate(Money::parse('5', 'EUR'), $this->at));
    }

    public function test_events_survive_a_json_round_trip(): void
    {
        $this->line->calculate(Money::parse('1000'), $this->at);
        $this->adjust('-45.55', 'dental benefit; reversing', 'k-1');

        foreach ($this->line->uncommittedEvents() as $event) {
            $copy = $event::fromPayload(json_decode(json_encode($event->toPayload()), true), $event->occurredAt());
            $this->assertEquals($event, $copy);
            $this->assertSame('anna:2026-01', $copy->aggregateId());
        }
        $this->assertInstanceOf(AdjustmentAdded::class, $copy);
    }

    /** @param class-string<\Throwable> $class */
    private function assertThrows(string $class, callable $fn): void
    {
        try {
            $fn();
            $this->fail("Expected {$class}");
        } catch (\Throwable $e) {
            $this->assertInstanceOf($class, $e);
        }
    }
}
