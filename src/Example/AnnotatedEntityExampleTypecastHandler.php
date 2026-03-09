<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToTimestampType;
use Sirix\Cycle\Extension\Typecast\Handler\TypecastHandler;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToStringType;

class AnnotatedEntityExampleTypecastHandler extends TypecastHandler
{
    protected function getConfig(): array
    {
        return [
            'uuid' => new UuidToStringType(),
            'createdAt' => new ChronosToTimestampType(),
            'updatedAt' => new ChronosToTimestampType(),
            'deletedAt' => new ChronosToTimestampType(),
        ];
    }
}
