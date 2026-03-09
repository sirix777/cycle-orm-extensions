<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Currency;

use Brick\Money\Currency;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Currency\CurrencyType;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

final class CurrencyTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new CurrencyType();
        $currency = Currency::of('USD');
        $context = new UncastContext('field', []);

        $this->assertEquals(840, $type->convertToDatabaseValue($currency, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new CurrencyType();
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-currency', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new CurrencyType();
        $context = new CastContext('field', []);

        $result = $type->convertToPhpValue(840, $context);
        $this->assertInstanceOf(Currency::class, $result);
        $this->assertEquals('USD', $result->getCurrencyCode());

        $result = $type->convertToPhpValue('978', $context);
        $this->assertEquals('EUR', $result->getCurrencyCode());
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new CurrencyType();
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue([], $context);
    }
}
