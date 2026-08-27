<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Currency;

use Attribute;
use Brick\Money\Currency;
use Brick\Money\Exception\UnknownCurrencyException;
use InvalidArgumentException;
use Override;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function is_numeric;
use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CurrencyType implements TypeInterface
{
    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): int
    {
        if (! $value instanceof Currency) {
            throw new InvalidArgumentException('Value must be an instance of Currency.');
        }

        $numericCode = $value->getNumericCode();
        if (null === $numericCode) {
            throw new InvalidArgumentException('Currency must have a numeric code.');
        }

        return $numericCode;
    }

    /**
     * @throws UnknownCurrencyException
     */
    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): Currency
    {
        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return Currency::ofNumericCode((int) $value);
    }
}
