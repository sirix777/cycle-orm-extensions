<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosUpdateTrait;

trait HasChronosUpdateTimestampAnnotatedTrait
{
    use HasChronosUpdateTrait;

    #[Column(type: 'int', nullable: true, unsigned: true)]
    private ?Chronos $updatedAt = null;
}
