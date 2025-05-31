<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait;

use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

trait HasIdIdentifierTrait
{
    protected ?int $id = null;

    public function setIdentifier(int|UuidInterface $identifier): void
    {
        if ($identifier instanceof UuidInterface) {
            throw new InvalidArgumentException('This entity only supports integer ID identifiers, UUID provided');
        }

        $this->id = $identifier;
    }

    public function getIdentifier(): ?int
    {
        return $this->id;
    }
}
