<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Chronos;

use Cake\Chronos\Chronos;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Throwable;

abstract class AbstractChronosType implements TypeInterface
{
    public function __construct(protected readonly string $timeZone = 'UTC') {}

    public function convertToDatabaseValue(mixed $value, UncastContext $context): mixed
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof Chronos) {
            throw new TypecastInvalidArgumentException('Incorrect value.');
        }

        try {
            return $this->toDatabaseValue($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    public function convertToPhpValue(mixed $value, CastContext $context): ?Chronos
    {
        if (null === $value) {
            return null;
        }

        try {
            return $this->toPhpValue($value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }

    abstract protected function toDatabaseValue(Chronos $value): mixed;

    abstract protected function toPhpValue(mixed $value): Chronos;
}
