<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Attribute;
use Brick\Money\Money;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MoneyMinorCurrencyCodeType extends AbstractMoneyType implements TypeInterface
{
    public function __construct(private readonly string $currencyCode = 'EUR') {}

    protected function toDatabaseValue(Money $value): string
    {
        return $this->minorAmountToDatabaseValue($value);
    }

    protected function toPhpValue(mixed $value, CastContext $context): Money
    {
        return Money::ofMinor($value, $this->currencyCode);
    }
}
