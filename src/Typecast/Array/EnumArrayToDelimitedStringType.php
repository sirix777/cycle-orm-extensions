<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Array;

use BackedEnum;
use InvalidArgumentException;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

use function explode;
use function implode;
use function is_array;
use function is_string;

class EnumArrayToDelimitedStringType implements TypeInterface
{
    /**
     * @param class-string<BackedEnum> $enumClass
     */
    public function __construct(private readonly string $enumClass, private readonly string $delimiter = ',') {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (! is_array($value)) {
            throw new InvalidArgumentException('Value must be an Enum array.');
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
            throw new InvalidArgumentException('Database value must be a string.');
        }

        if ('' === $this->delimiter) {
            throw new InvalidArgumentException('Delimiter cannot be empty.');
        }

        $values = explode($this->delimiter, $value);

        $enums = [];
        foreach ($values as $value) {
            $enums[] = $this->enumClass::from((int) $value);
        }

        return $enums;
    }
}
