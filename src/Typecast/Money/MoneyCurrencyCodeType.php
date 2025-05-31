<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Brick\Money\Money;
use Sirix\Money\CryptoCurrencyCode;
use Sirix\Money\Exception\SirixMoneyException;
use Sirix\Money\FiatCurrencyCode;
use Sirix\Money\SirixMoney;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;

final class MoneyCurrencyCodeType extends AbstractMoneyType implements TypeInterface
{
    public function __construct(private readonly CryptoCurrencyCode|FiatCurrencyCode $currencyCode = FiatCurrencyCode::Eur) {}

    /**
     * @throws SirixMoneyException
     */
    protected function toDatabaseValue(Money $value): string
    {
        $money = SirixMoney::of($value->getAmount(), $value->getCurrency()->getCurrencyCode());

        return SirixMoney::getAmount($money);
    }

    /**
     * @throws SirixMoneyException
     */
    protected function toPhpValue(mixed $value, CastContext $context): Money
    {
        return SirixMoney::of($value, $this->currencyCode->value);
    }
}
