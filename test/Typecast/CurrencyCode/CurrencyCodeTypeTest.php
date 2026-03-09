<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\CurrencyCode;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\CurrencyCode\CurrencyCodeType;
use Sirix\Money\CurrencyCode;
use Sirix\Money\FiatCurrencyCode;
use Sirix\Money\CryptoCurrencyCode;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

final class CurrencyCodeTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new CurrencyCodeType();
        $context = new UncastContext('field', []);

        $this->assertEquals(840, $type->convertToDatabaseValue(FiatCurrencyCode::Usd, $context));
        $this->assertEquals(1004, $type->convertToDatabaseValue(CryptoCurrencyCode::Btc, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new CurrencyCodeType();
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-currency-code', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new CurrencyCodeType();
        $context = new CastContext('field', []);

        $result = $type->convertToPhpValue(840, $context);
        $this->assertSame(FiatCurrencyCode::Usd, $result);

        $result = $type->convertToPhpValue('978', $context);
        $this->assertSame(FiatCurrencyCode::Eur, $result);
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new CurrencyCodeType();
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue([], $context);
    }
}
