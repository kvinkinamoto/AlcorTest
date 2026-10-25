<?php

declare(strict_types=1);

namespace Alcor\Payroll\SharedKernel;

use InvalidArgumentException;

/** Immutable amount in minor units (cents) of one currency, so there is no float rounding. */
final readonly class Money
{
    private const SYMBOLS = ['USD' => '$', 'EUR' => '€', 'UAH' => '₴'];

    private function __construct(public int $cents, public string $currency) {}

    public static function cents(int $cents, string $currency = 'USD'): self
    {
        return new self($cents, strtoupper($currency));
    }

    public static function zero(string $currency = 'USD'): self
    {
        return new self(0, strtoupper($currency));
    }

    /** Parses "1050.00", "-45.55", "+100.10" or "$1,104.45" (max 2 decimals). */
    public static function parse(string $value, string $currency = 'USD'): self
    {
        $clean = str_replace(['$', '€', '₴', ',', ' '], '', $value);

        if (!preg_match('/^([+-]?)(\d+)(?:\.(\d{1,2}))?$/', $clean, $m)) {
            throw new InvalidArgumentException("Invalid money amount: '{$value}'");
        }

        $cents = (int) $m[2] * 100 + (int) str_pad($m[3] ?? '', 2, '0');

        return new self($m[1] === '-' ? -$cents : $cents, strtoupper($currency));
    }

    public function plus(self $other): self
    {
        $this->assertSameCurrency($other);

        return new self($this->cents + $other->cents, $this->currency);
    }

    public function minus(self $other): self
    {
        $this->assertSameCurrency($other);

        return new self($this->cents - $other->cents, $this->currency);
    }

    public function isZero(): bool
    {
        return $this->cents === 0;
    }

    public function equals(self $other): bool
    {
        return $this->cents === $other->cents && $this->currency === $other->currency;
    }

    /** Plain decimal string, e.g. "-45.55" (for CSV and inputs). */
    public function toDecimal(): string
    {
        return sprintf('%s%d.%02d', $this->cents < 0 ? '-' : '', intdiv(abs($this->cents), 100), abs($this->cents) % 100);
    }

    public function format(bool $signed = false): string
    {
        $sign = $this->cents < 0 ? '-' : ($signed ? '+' : '');
        $symbol = self::SYMBOLS[$this->currency] ?? $this->currency . ' ';

        return sprintf('%s%s%s.%02d', $sign, $symbol, number_format(intdiv(abs($this->cents), 100)), abs($this->cents) % 100);
    }

    private function assertSameCurrency(self $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException("Currency mismatch: {$this->currency} vs {$other->currency}.");
        }
    }
}
