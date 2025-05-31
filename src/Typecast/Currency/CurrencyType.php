<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Currency;

use Brick\Money\Currency;
use InvalidArgumentException;
use Override;
use Sirix\Money\CurrencyCode;
use Sirix\Money\CurrencyRegistry;
use Sirix\Money\Exception\SirixMoneyException;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

use function is_numeric;
use function is_string;

class CurrencyType implements TypeInterface
{
    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): int
    {
        if (! $value instanceof Currency) {
            throw new InvalidArgumentException('Value must be an instance of Currency.');
        }

        return $value->getNumericCode();
    }

    /**
     * @throws SirixMoneyException
     */
    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): Currency
    {
        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return CurrencyRegistry::getInstance()->get(CurrencyCode::fromNumericCode((int) $value)->value);
    }
}
