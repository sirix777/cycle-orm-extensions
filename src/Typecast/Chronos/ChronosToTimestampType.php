<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Attribute;
use Cake\Chronos\Chronos;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;

use function is_int;
use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class ChronosToTimestampType extends AbstractChronosType
{
    protected function toDatabaseValue(Chronos $value): string
    {
        return (string) $value->getTimestamp();
    }

    protected function toPhpValue(mixed $value): Chronos
    {
        if (! is_string($value) && ! is_int($value)) {
            throw new TypecastInvalidArgumentException('Incorrect value.');
        }

        return Chronos::createFromTimestamp((int) $value, $this->timeZone);
    }
}
