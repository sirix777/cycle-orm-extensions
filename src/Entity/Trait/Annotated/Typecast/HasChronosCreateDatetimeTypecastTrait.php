<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosCreateTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateTimeStringType;

trait HasChronosCreateDatetimeTypecastTrait
{
    use HasChronosCreateTrait;

    #[Column(type: 'datetime')]
    #[ChronosToDateTimeStringType]
    private Chronos $createdAt;
}
