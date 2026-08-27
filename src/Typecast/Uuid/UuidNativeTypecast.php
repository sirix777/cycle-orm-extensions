<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Uuid;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Throwable;

use function is_string;
use function strlen;

/**
 * Native Cycle ORM-compatible typecast callbacks for UUID.
 *
 * Use with field-level rules, for example:
 * `->setTypecast([UuidNativeTypecast::class, 'toUuidFromString'])`.
 */
final class UuidNativeTypecast
{
    public static function toUuid(mixed $value): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value;
        }

        if (! is_string($value)) {
            throw new TypecastInvalidArgumentException('Database value must be string|UuidInterface|null.');
        }

        // Binary UUID(16) storage.
        if (16 === strlen($value)) {
            try {
                return Uuid::fromBytes($value);
            } catch (Throwable $exception) {
                throw TypecastInvalidArgumentException::wrap($exception);
            }
        }

        try {
            return Uuid::fromString($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    public static function toUuidFromString(mixed $value): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value;
        }

        if (! is_string($value)) {
            throw new TypecastInvalidArgumentException('Database value must be string|UuidInterface|null.');
        }

        try {
            return Uuid::fromString($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    public static function toUuidFromBytes(mixed $value): ?UuidInterface
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof UuidInterface) {
            return $value;
        }

        if (! is_string($value)) {
            throw new TypecastInvalidArgumentException('Database value must be bytes-string|UuidInterface|null.');
        }

        try {
            return Uuid::fromBytes($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }
}
