<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Domain\Contract;

use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Exception\EntityNotFoundException;

/**
 * @template TEntity of EntityInterface
 *
 * @extends RepositoryInterface<TEntity>
 */
interface ReadRepositoryInterface extends RepositoryInterface
{
    public function findByIdentifier(int|UuidInterface $identifier): ?EntityInterface;

    /**
     * @throws EntityNotFoundException
     */
    public function getByIdentifier(int|UuidInterface $identifier): EntityInterface;
}
