<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Array;

use BackedEnum;
use InvalidArgumentException;
use JsonException;

use function explode;
use function is_string;
use function json_decode;

/**
 * Native Cycle ORM-compatible typecast callbacks for array values.
 */
final class ArrayNativeTypecast
{
    /**
     * @return array<int, string>
     */
    public static function toArrayFromDelimitedString(mixed $value, string $delimiter = ','): array
    {
        if (null === $value || '' === $value) {
            return [];
        }

        if (! is_string($value)) {
            throw new InvalidArgumentException('Database value must be a string.');
        }

        if ('' === $delimiter) {
            throw new InvalidArgumentException('Delimiter cannot be empty.');
        }

        return explode($delimiter, $value);
    }

    /**
     * @param class-string<BackedEnum> $enumClass
     *
     * @return array<int, BackedEnum>
     */
    public static function toEnumArrayFromDelimitedString(mixed $value, string $enumClass, string $delimiter = ','): array
    {
        if (null === $value || '' === $value) {
            return [];
        }

        if (! is_string($value)) {
            throw new InvalidArgumentException('Database value must be a string.');
        }

        if ('' === $delimiter) {
            throw new InvalidArgumentException('Delimiter cannot be empty.');
        }

        $values = explode($delimiter, $value);
        $result = [];
        foreach ($values as $item) {
            $result[] = $enumClass::from((int) $item);
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    public static function toArrayFromJson(mixed $value): array
    {
        try {
            return json_decode((string) $value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new InvalidArgumentException('Database value must be a valid JSON string.');
        }
    }
}
