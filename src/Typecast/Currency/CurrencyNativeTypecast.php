<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Currency;

use Brick\Money\Currency;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Throwable;

use function is_numeric;
use function is_string;

/**
 * Native Cycle ORM-compatible typecast callbacks for currency values.
 */
final class CurrencyNativeTypecast
{
    public static function toCurrency(mixed $value): Currency
    {
        if (! is_string($value) && ! is_numeric($value)) {
            throw new TypecastInvalidArgumentException('Database value must be a string or numeric.');
        }

        try {
            return Currency::ofNumericCode((int) $value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }
}
