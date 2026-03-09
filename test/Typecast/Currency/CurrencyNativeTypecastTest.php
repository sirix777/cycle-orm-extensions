<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Currency;

use Brick\Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Currency\CurrencyNativeTypecast;

final class CurrencyNativeTypecastTest extends TestCase
{
    public function testToCurrency(): void
    {
        $result = CurrencyNativeTypecast::toCurrency(840);

        $this->assertInstanceOf(Currency::class, $result);
        $this->assertSame('USD', $result->getCurrencyCode());
    }

    public function testToCurrencyInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        CurrencyNativeTypecast::toCurrency([]);
    }
}
