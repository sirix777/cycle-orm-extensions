<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosDeleteTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateTimeStringType;

trait HasChronosDeleteDatetimeTypecastTrait
{
    use HasChronosDeleteTrait;

    #[Column(type: 'datetime', nullable: true)]
    #[ChronosToDateTimeStringType]
    private ?Chronos $deletedAt = null;
}
