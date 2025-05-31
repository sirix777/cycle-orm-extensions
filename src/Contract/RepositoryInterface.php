<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Contract;

use Cycle\ORM\RepositoryInterface as CycleRepositoryInterface;

/**
 * @template TEntity of EntityInterface
 *
 * @extends CycleRepositoryInterface<TEntity>
 */
interface RepositoryInterface extends CycleRepositoryInterface {}
