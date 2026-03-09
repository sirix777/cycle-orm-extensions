<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Currency;

use Brick\Money\Currency;
use InvalidArgumentException;
use Sirix\Money\CurrencyCode;
use Sirix\Money\CurrencyRegistry;
use Sirix\Money\Exception\SirixMoneyException;

use function is_numeric;
use function is_string;

/**
 * Native Cycle ORM-compatible typecast callbacks for currency values.
 */
final class CurrencyNativeTypecast
{
    /**
     * @throws SirixMoneyException
     */
    public static function toCurrency(mixed $value): Currency
    {
        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return CurrencyRegistry::getInstance()->get(CurrencyCode::fromNumericCode((int) $value)->value);
    }
}
