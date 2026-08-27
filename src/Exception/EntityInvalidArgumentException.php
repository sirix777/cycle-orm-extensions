<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Exception;

use InvalidArgumentException;

class EntityInvalidArgumentException extends InvalidArgumentException implements CycleExceptionInterface {}
