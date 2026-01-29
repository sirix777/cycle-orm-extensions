<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosUpdateTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToTimestampType;

trait HasChronosUpdateTimestampTypecastTrait
{
    use HasChronosUpdateTrait;

    #[Column(type: 'int', nullable: true, unsigned: true)]
    #[ChronosToTimestampType]
    private ?Chronos $updatedAt = null;
}
