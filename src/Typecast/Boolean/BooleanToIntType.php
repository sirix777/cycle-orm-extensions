<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Boolean;

use Attribute;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;

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
