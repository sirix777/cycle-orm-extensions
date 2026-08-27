<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Money;

use Brick\Money\Money;
use Override;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

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
            throw new TypecastInvalidArgumentException('Value must be an instance of Money.');
        }

        try {
            return $this->toDatabaseValue($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new TypecastInvalidArgumentException('Database value must be a string or numeric.');
        }

        try {
            return $this->toPhpValue($value, $context);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    final protected function amountToDatabaseValue(Money $value): string
    {
        return (string) $value->getAmount()->strippedOfTrailingZeros();
    }

    final protected function minorAmountToDatabaseValue(Money $value): string
    {
        return (string) $value->getMinorAmount();
    }

    abstract protected function toDatabaseValue(Money $value): string;

    abstract protected function toPhpValue(mixed $value, CastContext $context): Money;
}
