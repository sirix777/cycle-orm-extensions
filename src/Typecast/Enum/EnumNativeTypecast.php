<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Enum;

use BackedEnum;
use ReflectionEnum;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Throwable;

use function is_int;
use function is_string;
use function is_subclass_of;
use function preg_match;

/**
 * Native Cycle ORM-compatible typecast callbacks for backed enums.
 */
final class EnumNativeTypecast
{
    /**
     * @param class-string $enumClass
     *
     * @throws TypecastInvalidArgumentException
     */
    public static function toStringEnum(mixed $value, string $enumClass): ?BackedEnum
    {
        try {
            self::assertBackingType($enumClass, 'string');

            if (null === $value) {
                return null;
            }

            if ($value instanceof $enumClass && $value instanceof BackedEnum) {
                return $value;
            }

            if (! is_string($value)) {
                throw new TypecastInvalidArgumentException('Database value must be a string.');
            }

            $enum = $enumClass::from($value);

            if (! $enum instanceof BackedEnum) {
                throw new TypecastInvalidArgumentException('Enum class must be a backed enum.');
            }

            return $enum;
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    /**
     * @param class-string $enumClass
     *
     * @throws TypecastInvalidArgumentException
     */
    public static function toIntEnum(mixed $value, string $enumClass): ?BackedEnum
    {
        try {
            self::assertBackingType($enumClass, 'int');

            if (null === $value) {
                return null;
            }

            if ($value instanceof $enumClass && $value instanceof BackedEnum) {
                return $value;
            }

            if (! self::isIntOrNumericString($value)) {
                throw new TypecastInvalidArgumentException('Database value must be an int or numeric string.');
            }

            $enum = $enumClass::from((int) $value);

            if (! $enum instanceof BackedEnum) {
                throw new TypecastInvalidArgumentException('Enum class must be a backed enum.');
            }

            return $enum;
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    /**
     * @param class-string $enumClass
     *
     * @throws TypecastInvalidArgumentException
     */
    private static function assertBackingType(string $enumClass, string $expectedType): void
    {
        if (! is_subclass_of($enumClass, BackedEnum::class)) {
            throw new TypecastInvalidArgumentException('Enum class must be a backed enum.');
        }

        $backingType = (new ReflectionEnum($enumClass))->getBackingType()?->getName();

        if ($expectedType !== $backingType) {
            throw new TypecastInvalidArgumentException("Enum must be {$expectedType}-backed.");
        }
    }

    private static function isIntOrNumericString(mixed $value): bool
    {
        if (is_int($value)) {
            return true;
        }

        return is_string($value) && 1 === preg_match('/^-?\d+$/', $value);
    }
}
