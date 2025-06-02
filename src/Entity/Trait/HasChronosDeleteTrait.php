<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait;

use Cake\Chronos\Chronos;

trait HasChronosDeleteTrait
{
    private ?Chronos $deletedAt = null;

    public function getDeletedAt(): ?Chronos
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(Chronos $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
