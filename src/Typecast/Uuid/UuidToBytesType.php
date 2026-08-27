<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\Uuid;

use Attribute;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;

use function is_string;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class UuidToBytesType extends AbstractUuidType
{
    protected function toDatabaseValue(UuidInterface $value): string
    {
        return $value->getBytes();
    }

    protected function toPhpValue(mixed $value): UuidInterface
    {
        if (! is_string($value)) {
            throw new TypecastInvalidArgumentException('Incorrect value.');
        }

        return Uuid::fromBytes($value);
    }
}
