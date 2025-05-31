<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Brick\Money\Money;
use InvalidArgumentException;
use Sirix\Money\CurrencyCode;
use Sirix\Money\Exception\SirixMoneyException;
use Sirix\Money\SirixMoney;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;

use function array_key_exists;

final class MoneyMinorCurrencyNumericCodeColumnType extends AbstractMoneyType implements TypeInterface
{
    public function __construct(private readonly string $currencyCodeEntityProperty = 'currencyCode') {}

    /**
     * @throws SirixMoneyException
     */
    protected function toDatabaseValue(Money $value): string
    {
        $money = SirixMoney::of($value->getAmount(), $value->getCurrency()->getCurrencyCode());

        return SirixMoney::getMinorAmount($money);
    }

    /**
     * @throws InvalidArgumentException
     * @throws SirixMoneyException
     */
    protected function toPhpValue(mixed $value, CastContext $context): Money
    {
        if (! array_key_exists($this->currencyCodeEntityProperty, $context->data)) {
            throw new InvalidArgumentException("Entity property [{$this->currencyCodeEntityProperty}] not found in context.");
        }

        return SirixMoney::ofMinor($value, CurrencyCode::fromNumericCode($context->data[$this->currencyCodeEntityProperty]));
    }
}
