<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Array;

use InvalidArgumentException;
use JsonException;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

use function is_array;
use function json_decode;
use function json_encode;

final class ArrayToJsonType implements TypeInterface
{
    /**
     * @throws JsonException
     */
    public function convertToDatabaseValue(mixed $value, UncastContext $context): string
    {
        if (! is_array($value)) {
            throw new InvalidArgumentException('Value must be an array.');
        }

        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws InvalidArgumentException
     */
    public function convertToPhpValue(mixed $value, CastContext $context): array
    {
        try {
            return json_decode((string) $value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new InvalidArgumentException('Database value must be a valid JSON string.');
        }
    }
}
