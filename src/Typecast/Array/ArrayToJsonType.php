<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Array;

use Attribute;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

use function is_array;
use function json_decode;
use function json_encode;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ArrayToJsonType implements TypeInterface
{
    /**
     * @throws TypecastInvalidArgumentException
     */
    public function convertToDatabaseValue(mixed $value, UncastContext $context): string
    {
        if (! is_array($value)) {
            throw new TypecastInvalidArgumentException('Value must be an array.');
        }

        try {
            return json_encode($value, JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    /**
     * @return array<string, mixed>
     *
     * @throws TypecastInvalidArgumentException
     */
    public function convertToPhpValue(mixed $value, CastContext $context): array
    {
        try {
            $result = json_decode((string) $value, true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($result)) {
                throw new TypecastInvalidArgumentException('Database value must be a JSON array or object.');
            }

            return $result;
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }
}
