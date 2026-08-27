<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait;

use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Exception\EntityInvalidArgumentException;

trait HasIdIdentifierTrait
{
    private ?int $id = null;

    public function setIdentifier(int|UuidInterface $identifier): void
    {
        if ($identifier instanceof UuidInterface) {
            throw new EntityInvalidArgumentException('This entity only supports integer ID identifiers, UUID provided');
        }

        $this->id = $identifier;
    }

    public function getIdentifier(): ?int
    {
        return $this->id;
    }
}
