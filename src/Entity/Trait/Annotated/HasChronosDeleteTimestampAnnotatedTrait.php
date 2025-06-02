<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosDeleteTrait;

trait HasChronosDeleteTimestampAnnotatedTrait
{
    use HasChronosDeleteTrait;

    #[Column(type: 'int', unsigned: true)]
    private ?Chronos $deletedAt = null;
}
