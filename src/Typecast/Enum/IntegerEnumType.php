<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Enum;

use Attribute;
use BackedEnum;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

use function is_int;
use function is_string;
use function preg_match;

#[Attribute(Attribute::TARGET_PROPERTY)]
final readonly class IntegerEnumType implements TypeInterface
{
    /**
     * @param class-string<BackedEnum> $enumClass
     */
    public function __construct(private string $enumClass) {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?int
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof $this->enumClass) {
            throw new TypecastInvalidArgumentException('Value must be an instance of the configured enum class.');
        }

        if (! is_int($value->value)) {
            throw new TypecastInvalidArgumentException('Enum must be int-backed.');
        }

        return $value->value;
    }

    public function convertToPhpValue(mixed $value, CastContext $context): ?BackedEnum
    {
        if (null === $value) {
            return null;
        }

        if (! $this->isIntOrNumericString($value)) {
            throw new TypecastInvalidArgumentException('Database value must be int or numeric string.');
        }

        try {
            return $this->enumClass::from((int) $value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    private function isIntOrNumericString(mixed $value): bool
    {
        if (is_int($value)) {
            return true;
        }

        if (! is_string($value)) {
            return false;
        }

        return 1 === preg_match('/^-?\d+$/', $value);
    }
}
