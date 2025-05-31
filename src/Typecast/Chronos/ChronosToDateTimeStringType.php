<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;

use function is_int;
use function is_string;

final class ChronosToDateTimeStringType extends AbstractChronosType
{
    protected function toDatabaseValue(Chronos $value): string
    {
        return $value->toDateTimeString();
    }

    protected function toPhpValue(mixed $value): Chronos
    {
        if (! is_string($value) && ! is_int($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        if (is_int($value)) {
            $value = (string) $value;
        }

        return Chronos::createFromFormat(Chronos::DEFAULT_TO_STRING_FORMAT, $value, $this->timeZone);
    }
}
