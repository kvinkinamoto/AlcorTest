<?php

declare(strict_types=1);

namespace Alcor\Payroll\Tests;

use Alcor\Payroll\SharedKernel\Money;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    #[DataProvider('parsed')]
    public function test_parse(string $input, int $cents): void
    {
        $this->assertSame($cents, Money::parse($input)->cents);
    }

    public static function parsed(): iterable
    {
        yield ['1000', 100000];
        yield ['1050.00', 105000];
        yield ['-45.55', -4555];
        yield ['+100.10', 10010];
        yield ['-0.10', -10];
        yield ['$1,104.45', 110445];
        yield ['0.5', 50];
    }

    public function test_rejects_more_than_two_decimals(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Money::parse('12.345');
    }

    public function test_formats_with_sign_thousands_and_currency(): void
    {
        $this->assertSame('$1,104.45', Money::cents(110445)->format());
        $this->assertSame('-$0.10', Money::cents(-10)->format());
        $this->assertSame('+$100.10', Money::cents(10010)->format(signed: true));
        $this->assertSame('€10.00', Money::cents(1000, 'EUR')->format());
        $this->assertSame('CHF 10.00', Money::cents(1000, 'CHF')->format());
    }

    public function test_addition_is_exact(): void
    {
        $sum = Money::parse('0.10')->plus(Money::parse('0.20'));
        $this->assertTrue($sum->equals(Money::parse('0.30')));
    }

    public function test_currencies_cannot_be_mixed(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Money::parse('1', 'USD')->plus(Money::parse('1', 'EUR'));
    }

    public function test_decimal_roundtrip(): void
    {
        $this->assertSame('-45.55', Money::parse('-45.55')->toDecimal());
        $this->assertSame('0.05', Money::parse('0.05')->toDecimal());
    }
}
