<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;

use function is_int;
use function is_string;

final class ChronosToTimestampType extends AbstractChronosType
{
    protected function toDatabaseValue(Chronos $value): string
    {
        return (string) $value->getTimestamp();
    }

    protected function toPhpValue(mixed $value): Chronos
    {
        if (! is_string($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return Chronos::createFromTimestamp((int) $value, $this->timeZone);
    }
}
