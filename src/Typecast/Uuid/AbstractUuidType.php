<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Uuid;

use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

abstract class AbstractUuidType implements TypeInterface
{
    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof UuidInterface) {
            throw new TypecastInvalidArgumentException('Incorrect value.');
        }

        try {
            return $this->toDatabaseValue($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    public function convertToPhpValue(mixed $value, CastContext $context): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        try {
            return $this->toPhpValue($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    abstract protected function toDatabaseValue(UuidInterface $value): mixed;

    abstract protected function toPhpValue(mixed $value): UuidInterface;
}
