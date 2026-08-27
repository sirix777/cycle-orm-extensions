<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Array;

use Attribute;
use BackedEnum;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

use function explode;
use function implode;
use function is_array;
use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class EnumArrayToDelimitedStringType implements TypeInterface
{
    /**
     * @param class-string<BackedEnum> $enumClass
     */
    public function __construct(private string $enumClass, private string $delimiter = ',') {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (! is_array($value)) {
            throw new TypecastInvalidArgumentException('Value must be an Enum array.');
        }

        $ids = [];
        foreach ($value as $enum) {
            if ($enum instanceof $this->enumClass) {
                $ids[] = $enum->value;
            }
        }

        return implode($this->delimiter, $ids);
    }

    /**
     * @return array<int, BackedEnum>
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

        $values = explode($this->delimiter, $value);

        $enums = [];

        try {
            foreach ($values as $value) {
                $enums[] = $this->enumClass::from((int) $value);
            }
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }

        return $enums;
    }
}
