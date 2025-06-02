<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Contract;

use Sirix\Cycle\Extension\Exception\RepositoryPersistException;

/**
 * @template TEntity of EntityInterface
 *
 * @extends ReadRepositoryInterface<TEntity>
 */
interface WriteRepositoryInterface extends ReadRepositoryInterface
{
    public function persist(EntityInterface $entity, bool $cascade, bool $flush): void;

    /**
     * @throws RepositoryPersistException
     */
    public function persistAndFlush(EntityInterface $entity, bool $cascade): void;

    public function delete(EntityInterface $entity, bool $cascade, bool $flush): void;

    /**
     * @throws RepositoryPersistException
     */
    public function deleteAndFlush(EntityInterface $entity, bool $cascade): void;

    /**
     * @throws RepositoryPersistException
     */
    public function flush(): void;
}
