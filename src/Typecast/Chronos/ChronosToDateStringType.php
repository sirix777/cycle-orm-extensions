<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;

use function is_string;

final class ChronosToDateStringType extends AbstractChronosType
{
    protected function toDatabaseValue(Chronos $value): string
    {
        return $value->toDateString();
    }

    protected function toPhpValue(mixed $value): Chronos
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return Chronos::createFromFormat('Y-m-d', $value, $this->timeZone)->startOfDay();
    }
}
