<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Exception;

use InvalidArgumentException;
use Throwable;

class TypecastInvalidArgumentException extends InvalidArgumentException implements CycleExceptionInterface
{
    public static function wrap(Throwable $exception): self
    {
        if ($exception instanceof self) {
            return $exception;
        }

        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
