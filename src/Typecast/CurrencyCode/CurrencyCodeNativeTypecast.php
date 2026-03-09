<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\CurrencyCode;

use InvalidArgumentException;
use Sirix\Money\CryptoCurrencyCode;
use Sirix\Money\CurrencyCode;
use Sirix\Money\Exception\SirixMoneyException;
use Sirix\Money\FiatCurrencyCode;

use function is_numeric;
use function is_string;

/**
 * Native Cycle ORM-compatible typecast callbacks for currency code values.
 */
final class CurrencyCodeNativeTypecast
{
    /**
     * @throws SirixMoneyException
     */
    public static function toCurrencyCode(mixed $value): CryptoCurrencyCode|FiatCurrencyCode
    {
        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return CurrencyCode::fromNumericCode((int) $value);
    }
}
