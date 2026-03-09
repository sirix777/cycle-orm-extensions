<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Brick\Money\Money;
use InvalidArgumentException;
use Sirix\Money\CurrencyCode;
use Sirix\Money\Exception\SirixMoneyException;
use Sirix\Money\SirixMoney;

use function is_numeric;
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
     * @throws SirixMoneyException
     */
    public static function toMoneyByCurrencyCode(mixed $value, string $currencyCode = 'EUR'): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return SirixMoney::of($value, $currencyCode);
    }

    /**
     * @throws SirixMoneyException
     */
    public static function toMinorMoneyByCurrencyCode(mixed $value, string $currencyCode = 'EUR'): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return SirixMoney::ofMinor($value, $currencyCode);
    }

    /**
     * @throws SirixMoneyException
     */
    public static function toMoneyByNumericCode(mixed $value, int $numericCode): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return SirixMoney::of($value, CurrencyCode::fromNumericCode($numericCode));
    }

    /**
     * @throws SirixMoneyException
     */
    public static function toMinorMoneyByNumericCode(mixed $value, int $numericCode): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return SirixMoney::ofMinor($value, CurrencyCode::fromNumericCode($numericCode));
    }
}
