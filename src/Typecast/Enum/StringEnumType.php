<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Enum;

use Attribute;
use BackedEnum;
use InvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class StringEnumType implements TypeInterface
{
    /**
     * @param class-string<BackedEnum> $enumClass
     */
    public function __construct(private string $enumClass) {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?string
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof $this->enumClass) {
            throw new InvalidArgumentException('Value must be an instance of the configured enum class.');
        }

        if (! is_string($value->value)) {
            throw new InvalidArgumentException('Enum must be string-backed.');
        }

        return $value->value;
    }

    public function convertToPhpValue(mixed $value, CastContext $context): ?BackedEnum
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value)) {
            throw new InvalidArgumentException('Database value must be a string.');
        }

        return $this->enumClass::from($value);
    }
}
