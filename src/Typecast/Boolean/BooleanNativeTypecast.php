<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Boolean;

/**
 * Native Cycle ORM-compatible typecast callbacks for boolean values.
 */
final class BooleanNativeTypecast
{
    public static function toBool(mixed $value): bool
    {
        return (bool) $value;
    }
}
