<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Boolean;

use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

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
