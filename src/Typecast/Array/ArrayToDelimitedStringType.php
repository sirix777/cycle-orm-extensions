<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Array;

use Attribute;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function explode;
use function implode;
use function is_array;
use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class ArrayToDelimitedStringType implements TypeInterface
{
    public function __construct(private string $delimiter = ',') {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?string
    {
        if (! is_array($value)) {
            throw new TypecastInvalidArgumentException('Value must be an array.');
        }

        if ([] === $value) {
            return null;
        }

        return implode($this->delimiter, $value);
    }

    /**
     * @return array<int, string>
     */
    public function convertToPhpValue(mixed $value, CastContext $context): array
    {
        if (null === $value) {
            return [];
        }

        if ('' === $value) {
            return [];
        }

        if (! is_string($value)) {
            throw new TypecastInvalidArgumentException('Database value must be a string.');
        }

        if ('' === $this->delimiter) {
            throw new TypecastInvalidArgumentException('Delimiter cannot be empty.');
        }

        return explode($this->delimiter, $value);
    }
}
