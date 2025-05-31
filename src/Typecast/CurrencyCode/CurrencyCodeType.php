<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\CurrencyCode;

use InvalidArgumentException;
use Override;
use Sirix\Money\CryptoCurrencyCode;
use Sirix\Money\CurrencyCode;
use Sirix\Money\Exception\SirixMoneyException;
use Sirix\Money\FiatCurrencyCode;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

use function is_numeric;
use function is_string;

class CurrencyCodeType implements TypeInterface
{
    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): int
    {
        if (! $value instanceof FiatCurrencyCode && ! $value instanceof CryptoCurrencyCode) {
            throw new InvalidArgumentException('Value must be an instance of FiatCurrencyCode or CryptoCurrencyCode.');
        }

        return $value->numericCode();
    }

    /**
     * @throws SirixMoneyException
     */
    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): CryptoCurrencyCode|FiatCurrencyCode
    {
        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return CurrencyCode::fromNumericCode((int) $value);
    }
}
