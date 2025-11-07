<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosCreateTrait;

trait HasChronosCreateDatetimeAnnotatedTrait
{
    use HasChronosCreateTrait;

    #[Column(type: 'datetime')]
    private Chronos $createdAt;
}
