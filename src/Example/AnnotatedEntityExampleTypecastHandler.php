<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToTimestampType;
use Vjik\CycleTypecast\TypecastHandler;

class AnnotatedEntityExampleTypecastHandler extends TypecastHandler
{
    protected function getConfig(): array
    {
        return [
            'createdAt' => new ChronosToTimestampType(),
            'updatedAt' => new ChronosToTimestampType(),
            'deletedAt' => new ChronosToTimestampType(),
        ];
    }
}
