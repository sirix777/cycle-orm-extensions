<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Attribute;
use Brick\Money\Currency;
use Brick\Money\Money;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function array_key_exists;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class MoneyMinorCurrencyNumericCodeColumnType extends AbstractMoneyType implements TypeInterface
{
    public function __construct(private readonly string $currencyCodeEntityProperty = 'currencyCode') {}

    protected function toDatabaseValue(Money $value): string
    {
        return $this->minorAmountToDatabaseValue($value);
    }

    protected function toPhpValue(mixed $value, CastContext $context): Money
    {
        if (! array_key_exists($this->currencyCodeEntityProperty, $context->data)) {
            throw new TypecastInvalidArgumentException("Entity property [{$this->currencyCodeEntityProperty}] not found in context.");
        }

        return Money::ofMinor($value, Currency::ofNumericCode((int) $context->data[$this->currencyCodeEntityProperty]));
    }
}
