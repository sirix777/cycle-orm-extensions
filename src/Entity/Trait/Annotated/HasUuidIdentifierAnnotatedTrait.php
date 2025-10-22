<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated;

use Cycle\Annotated\Annotation\Column;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Entity\Trait\HasUuidIdentifierTrait;

trait HasUuidIdentifierAnnotatedTrait
{
    use HasUuidIdentifierTrait;

    #[Column(type: 'uuid', primary: true)]
    private UuidInterface $uuid;
}
