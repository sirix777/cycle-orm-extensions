<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Money;

use Brick\Money\Money;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Money\MoneyCurrencyNumericCodeColumnType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class MoneyCurrencyNumericCodeColumnTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new MoneyCurrencyNumericCodeColumnType();
        $money = Money::of('10.50', 'USD');
        $context = new UncastContext('field', []);

        $this->assertEquals('10.5', $type->convertToDatabaseValue($money, $context));
        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToPhpValue(): void
    {
        $type = new MoneyCurrencyNumericCodeColumnType('currency_column');
        $context = new CastContext('field', ['currency_column' => 840]);

        $result = $type->convertToPhpValue('10.50', $context);
        $this->assertInstanceOf(Money::class, $result);
        $this->assertEquals('10.50', $result->getAmount()->__toString());
        $this->assertEquals('USD', $result->getCurrency()->getCurrencyCode());

        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueMissingCurrency(): void
    {
        $type = new MoneyCurrencyNumericCodeColumnType('currency_column');
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('10.50', $context);
    }
}
