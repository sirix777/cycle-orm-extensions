<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\SirixMoney;

use Brick\Money\Currency;
use Brick\Money\Money;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\SirixMoney\CurrencyType;
use Sirix\Cycle\Extension\Typecast\SirixMoney\MoneyCurrencyCodeColumnType;
use Sirix\Cycle\Extension\Typecast\SirixMoney\MoneyCurrencyCodeType;
use Sirix\Cycle\Extension\Typecast\SirixMoney\MoneyMinorCurrencyCodeColumnType;
use Sirix\Cycle\Extension\Typecast\SirixMoney\MoneyMinorCurrencyCodeType;
use Sirix\Money\Currency\ArrayCurrencyCatalog;
use Sirix\Money\MoneyFactory;

final class SirixMoneyTypeTest extends TestCase
{
    public function testCurrencyTypeUsesTheInjectedCatalog(): void
    {
        $type = new CurrencyType($this->catalog());
        $context = new CastContext('currency', []);

        $currency = $type->convertToPhpValue(9001, $context);

        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertSame('CREDIT', $currency->getCurrencyCode());
        $this->assertSame(9001, $type->convertToDatabaseValue($currency, new UncastContext('currency', [])));
    }

    public function testMoneyCurrencyCodeTypeUsesTheInjectedFactory(): void
    {
        $type = new MoneyCurrencyCodeType($this->factory(), 'credit');
        $context = new CastContext('amount', []);

        $money = $type->convertToPhpValue('10.50', $context);

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('CREDIT', $money->getCurrency()->getCurrencyCode());
        $this->assertSame('10.5', $type->convertToDatabaseValue($money, new UncastContext('amount', [])));
    }

    public function testMoneyMinorCurrencyCodeTypeUsesTheInjectedFactory(): void
    {
        $type = new MoneyMinorCurrencyCodeType($this->factory(), 9001);
        $money = $type->convertToPhpValue(1050, new CastContext('amount', []));

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('10.50', (string) $money->getAmount());
        $this->assertSame('1050', $type->convertToDatabaseValue($money, new UncastContext('amount', [])));
    }

    public function testMoneyCurrencyCodeColumnTypeUsesTheCatalogCodeFromContext(): void
    {
        $type = new MoneyCurrencyCodeColumnType($this->factory(), 'currency_code');
        $money = $type->convertToPhpValue('10.50', new CastContext('amount', ['currency_code' => 'CREDIT']));

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('CREDIT', $money->getCurrency()->getCurrencyCode());
    }

    public function testMoneyMinorCurrencyCodeColumnTypeUsesTheCatalogCodeFromContext(): void
    {
        $type = new MoneyMinorCurrencyCodeColumnType($this->factory(), 'currency_code');
        $money = $type->convertToPhpValue(1050, new CastContext('amount', ['currency_code' => 9001]));

        $this->assertInstanceOf(Money::class, $money);
        $this->assertSame('CREDIT', $money->getCurrency()->getCurrencyCode());
    }

    private function factory(): MoneyFactory
    {
        return new MoneyFactory($this->catalog());
    }

    private function catalog(): ArrayCurrencyCatalog
    {
        return new ArrayCurrencyCatalog(new Currency('CREDIT', 9001, 'Store credit', 2));
    }
}
