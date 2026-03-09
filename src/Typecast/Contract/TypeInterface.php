<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Contract;

use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

/**
 * Internal typecast contract derived from and adapted after
 * vjik/cycle-typecast (BSD-3-Clause).
 *
 * @see https://github.com/vjik/cycle-typecast
 */
interface TypeInterface
{
    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed;

    public function convertToPhpValue(mixed $value, CastContext $context): mixed;
}
