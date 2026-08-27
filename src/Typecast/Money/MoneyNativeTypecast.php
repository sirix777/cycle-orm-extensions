<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Brick\Money\Currency;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use InvalidArgumentException;

use function is_int;
use function is_string;

/**
 * Native Cycle ORM-compatible typecast callbacks for money values.
 *
 * Note:
 * Native callbacks do not have row-level context, so column-dependent conversions
 * (like Money*NumericCodeColumnType) should continue using custom handlers.
 */
final class MoneyNativeTypecast
{
    /**
     * @throws UnknownCurrencyException
     */
    public static function toMoneyByCurrencyCode(mixed $value, string $currencyCode = 'EUR'): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Database value must be a string or integer.');
        }

        return Money::of($value, $currencyCode);
    }

    /**
     * @throws UnknownCurrencyException
     */
    public static function toMinorMoneyByCurrencyCode(mixed $value, string $currencyCode = 'EUR'): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Database value must be a string or integer.');
        }

        return Money::ofMinor($value, $currencyCode);
    }

    /**
     * @throws UnknownCurrencyException
     */
    public static function toMoneyByNumericCode(mixed $value, int $numericCode): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Database value must be a string or integer.');
        }

        return Money::of($value, Currency::ofNumericCode($numericCode));
    }

    /**
     * @throws UnknownCurrencyException
     */
    public static function toMinorMoneyByNumericCode(mixed $value, int $numericCode): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Database value must be a string or integer.');
        }

        return Money::ofMinor($value, Currency::ofNumericCode($numericCode));
    }
}
