<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast;

use Cycle\Annotated\Annotation\Column;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Entity\Trait\HasUuidIdentifierTrait;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToStringType;

trait HasUuidIdentifierStringTypecastTrait
{
    use HasUuidIdentifierTrait;

    #[Column(type: 'string(36)', primary: true)]
    #[UuidToStringType]
    private UuidInterface $uuid;
}
