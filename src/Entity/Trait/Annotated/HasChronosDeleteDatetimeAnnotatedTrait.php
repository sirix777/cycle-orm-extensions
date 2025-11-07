<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosDeleteTrait;

trait HasChronosDeleteDatetimeAnnotatedTrait
{
    use HasChronosDeleteTrait;

    #[Column(type: 'datetime', nullable: true)]
    private ?Chronos $deletedAt = null;
}
