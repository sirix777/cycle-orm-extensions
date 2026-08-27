<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Currency;

use Attribute;
use Brick\Money\Currency;
use Override;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

use function is_numeric;
use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class CurrencyType implements TypeInterface
{
    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): int
    {
        if (! $value instanceof Currency) {
            throw new TypecastInvalidArgumentException('Value must be an instance of Currency.');
        }

        $numericCode = $value->getNumericCode();
        if (null === $numericCode) {
            throw new TypecastInvalidArgumentException('Currency must have a numeric code.');
        }

        return $numericCode;
    }

    /**
     * @throws TypecastInvalidArgumentException
     */
    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): Currency
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
