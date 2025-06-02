<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

trait HasUuidIdentifierTrait
{
    private UuidInterface $uuid;

    /**
     * Generate a new UUID.
     *
     * @param int   $version UUID version to generate (1-8)
     * @param mixed ...$args Additional arguments required for specific UUID versions
     */
    public function next(int $version = 7, ...$args): UuidInterface
    {
        return match ($version) {
            1 => Uuid::uuid1(...$args),
            2 => Uuid::uuid2(...$args),
            3 => Uuid::uuid3(...$args),
            4 => Uuid::uuid4(),
            5 => Uuid::uuid5(...$args),
            6 => Uuid::uuid6(...$args),
            8 => Uuid::uuid8(...$args),
            default => Uuid::uuid7(),
        };
    }

    public function setIdentifier(int|UuidInterface $identifier): void
    {
        if (! $identifier instanceof UuidInterface) {
            throw new InvalidArgumentException('This entity only supports UUID identifiers, integer provided');
        }

        $this->uuid = $identifier;
    }

    public function getIdentifier(): UuidInterface
    {
        return $this->uuid;
    }
}
