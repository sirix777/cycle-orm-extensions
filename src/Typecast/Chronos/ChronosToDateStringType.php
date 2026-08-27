<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Attribute;
use Cake\Chronos\Chronos;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;

use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ChronosToDateStringType extends AbstractChronosType
{
    protected function toDatabaseValue(Chronos $value): string
    {
        return $value->toDateString();
    }

    protected function toPhpValue(mixed $value): Chronos
    {
        if (! is_string($value)) {
            throw new TypecastInvalidArgumentException('Incorrect value.');
        }

        return Chronos::createFromFormat('Y-m-d', $value, $this->timeZone)->startOfDay();
    }
}
