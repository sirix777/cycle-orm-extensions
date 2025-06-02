<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait;

use Cake\Chronos\Chronos;

trait HasChronosUpdateTrait
{
    private ?Chronos $updatedAt = null;

    public function getUpdatedAt(): ?Chronos
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Chronos $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
