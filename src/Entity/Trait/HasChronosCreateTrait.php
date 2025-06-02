<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait;

use Cake\Chronos\Chronos;

trait HasChronosCreateTrait
{
    private ?Chronos $createdAt = null;

    public function getCreatedAt(): ?Chronos
    {
        return $this->createdAt;
    }

    public function setCreatedAt(Chronos $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
