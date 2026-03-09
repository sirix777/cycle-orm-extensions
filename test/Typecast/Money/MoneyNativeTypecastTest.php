<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Money;

use Brick\Money\Money;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Money\MoneyNativeTypecast;

final class MoneyNativeTypecastTest extends TestCase
{
    public function testToMoneyByCurrencyCode(): void
    {
        $result = MoneyNativeTypecast::toMoneyByCurrencyCode('10.50', 'USD');

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame('10.50', $result->getAmount()->__toString());
        $this->assertSame('USD', $result->getCurrency()->getCurrencyCode());
    }

    public function testToMinorMoneyByCurrencyCode(): void
    {
        $result = MoneyNativeTypecast::toMinorMoneyByCurrencyCode(1050, 'USD');

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame('10.50', $result->getAmount()->__toString());
        $this->assertSame('USD', $result->getCurrency()->getCurrencyCode());
    }

    public function testToMoneyByNumericCode(): void
    {
        $result = MoneyNativeTypecast::toMoneyByNumericCode('10.50', 840);

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame('USD', $result->getCurrency()->getCurrencyCode());
    }

    public function testToMinorMoneyByNumericCode(): void
    {
        $result = MoneyNativeTypecast::toMinorMoneyByNumericCode(1050, 840);

        $this->assertInstanceOf(Money::class, $result);
        $this->assertSame('USD', $result->getCurrency()->getCurrencyCode());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        MoneyNativeTypecast::toMoneyByCurrencyCode([]);
    }
}
