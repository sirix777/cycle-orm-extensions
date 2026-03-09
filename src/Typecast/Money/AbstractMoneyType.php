<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Brick\Money\Money;
use InvalidArgumentException;
use Override;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function is_numeric;
use function is_string;

abstract class AbstractMoneyType implements TypeInterface
{
    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?string
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof Money) {
            throw new InvalidArgumentException('Value must be an instance of Money.');
        }

        return $this->toDatabaseValue($value);
    }

    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return $this->toPhpValue($value, $context);
    }

    abstract protected function toDatabaseValue(Money $value): mixed;

    abstract protected function toPhpValue(mixed $value, CastContext $context): Money;
}
