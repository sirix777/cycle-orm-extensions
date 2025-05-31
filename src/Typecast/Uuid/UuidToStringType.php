<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Uuid;

use Exception;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function is_string;

class UuidToStringType extends AbstractUuidType
{
    protected function toDatabaseValue(UuidInterface $value): string
    {
        return $value->toString();
    }

    protected function toPhpValue(mixed $value): UuidInterface
    {
        if (! is_string($value)) {
            throw new InvalidArgumentException('Incorrect value.');
        }

        try {
            $uuid = Uuid::fromString($value);
        } catch (Exception) {
            throw new InvalidArgumentException();
        }

        return $uuid;
    }
}
