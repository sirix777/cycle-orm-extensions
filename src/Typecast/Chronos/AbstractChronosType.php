<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\TypeInterface;
use Vjik\CycleTypecast\UncastContext;

abstract class AbstractChronosType implements TypeInterface
{
    public function __construct(protected readonly string $timeZone = 'UTC') {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof Chronos) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        return $this->toDatabaseValue($value);
    }

    public function convertToPhpValue(mixed $value, CastContext $context): ?Chronos
    {
        if (null === $value) {
            return null;
        }

        return $this->toPhpValue($value);
    }

    abstract protected function toDatabaseValue(Chronos $value): mixed;

    abstract protected function toPhpValue(mixed $value): Chronos;
}
