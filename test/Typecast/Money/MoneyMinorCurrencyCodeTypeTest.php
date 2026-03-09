<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Money;

use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Money\MoneyMinorCurrencyCodeType;
use Sirix\Money\FiatCurrencyCode;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

final class MoneyMinorCurrencyCodeTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new MoneyMinorCurrencyCodeType(FiatCurrencyCode::Usd);
        $money = Money::of('10.50', 'USD');
        $context = new UncastContext('field', []);

        $this->assertEquals('1050', $type->convertToDatabaseValue($money, $context));
        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToPhpValue(): void
    {
        $type = new MoneyMinorCurrencyCodeType(FiatCurrencyCode::Usd);
        $context = new CastContext('field', []);

        $result = $type->convertToPhpValue(1050, $context);
        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals('10.50', $result->getAmount()->__toString());
        $this->assertEquals('USD', $result->getCurrency()->getCurrencyCode());

        $this->assertNull($type->convertToPhpValue(null, $context));
    }
}
