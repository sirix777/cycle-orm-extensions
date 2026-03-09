<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Uuid;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
            throw new InvalidArgumentException('Database value must be string|UuidInterface|null.');
        }

        // Binary UUID(16) storage.
        if (16 === strlen($value)) {
            return Uuid::fromBytes($value);
        }

        return Uuid::fromString($value);
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
            throw new InvalidArgumentException('Database value must be string|UuidInterface|null.');
        }

        return Uuid::fromString($value);
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
            throw new InvalidArgumentException('Database value must be bytes-string|UuidInterface|null.');
        }

        return Uuid::fromBytes($value);
    }
}
