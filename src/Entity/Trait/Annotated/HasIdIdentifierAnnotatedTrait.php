<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated;

use Cycle\Annotated\Annotation\Column;
use Sirix\Cycle\Extension\Entity\Trait\HasIdIdentifierTrait;

trait HasIdIdentifierAnnotatedTrait
{
    use HasIdIdentifierTrait;

    #[Column(type: 'bigPrimary')]
    protected ?int $id = null;
}
