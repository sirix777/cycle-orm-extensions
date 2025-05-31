<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Uuid;

use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

abstract class AbstractUuidType implements TypeInterface
{
    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof UuidInterface) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return $this->toDatabaseValue($value);
    }

    public function convertToPhpValue(mixed $value, CastContext $context): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        return $this->toPhpValue($value);
    }

    abstract protected function toDatabaseValue(UuidInterface $value): mixed;

    abstract protected function toPhpValue(mixed $value): UuidInterface;
}
