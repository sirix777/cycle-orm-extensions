<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast;

use Cycle\Annotated\Annotation\Column;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Entity\Trait\HasUuidIdentifierTrait;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToBytesType;

trait HasUuidIdentifierByteTypecastTrait
{
    use HasUuidIdentifierTrait;

    #[Column(type: 'binary(16)', primary: true)]
    #[UuidToBytesType]
    private UuidInterface $uuid;
}
