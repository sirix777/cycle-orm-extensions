<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Cake\Chronos\Chronos;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

use function is_int;
use function is_numeric;
use function is_string;

/**
 * Native Cycle ORM-compatible typecast callbacks for Chronos.
 *
 * Use with field-level rules, for example:
 * `->setTypecast([ChronosNativeTypecast::class, 'toChronos'])`.
 */
final class ChronosNativeTypecast
{
    public static function toChronos(mixed $value): ?Chronos
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof Chronos) {
            return $value;
        }

        if ($value instanceof DateTimeImmutable) {
            return Chronos::instance($value);
        }

        if ($value instanceof DateTimeInterface) {
            return Chronos::instance(DateTimeImmutable::createFromInterface($value));
        }

        if (is_string($value)) {
            return new Chronos($value);
        }

        throw new InvalidArgumentException('Database value must be DateTimeInterface|string|null.');
    }

    public static function toChronosFromTimestamp(mixed $value, string $timeZone = 'UTC'): ?Chronos
    {
        if (null === $value) {
            return null;
        }

        if (! is_int($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be int|string-numeric|null.');
        }

        return Chronos::createFromTimestamp((int) $value, $timeZone);
    }
}
