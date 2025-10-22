<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Domain\Contract;

use Ramsey\Uuid\UuidInterface;

interface EntityInterface
{
    public function getIdentifier(): int|UuidInterface|null;

    public function setIdentifier(int|UuidInterface $identifier): void;
}
