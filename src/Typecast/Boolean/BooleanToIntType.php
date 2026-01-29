<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Boolean;

use Attribute;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class BooleanToIntType implements TypeInterface
{
    public function convertToDatabaseValue(mixed $value, UncastContext $context): int
    {
        return (int) $value;
    }

    public function convertToPhpValue(mixed $value, CastContext $context): bool
    {
        return (bool) $value;
    }
}
