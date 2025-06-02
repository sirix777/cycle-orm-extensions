<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Repository;

use Cycle\ORM\EntityManager;
use Cycle\ORM\ORMInterface;
use Sirix\Cycle\Extension\Contract\EntityInterface;
use Sirix\Cycle\Extension\Contract\WriteRepositoryInterface;
use Sirix\Cycle\Extension\Exception\RepositoryPersistException;
use Sirix\Cycle\Extension\Factory\SelectFactory;
use Throwable;

/**
 * @template TEntity of EntityInterface
 *
 * @extends AbstractReadRepository<TEntity>
 *
 * @implements WriteRepositoryInterface<TEntity>
 */
abstract class AbstractWriteRepository extends AbstractReadRepository implements WriteRepositoryInterface
{
    private readonly EntityManager $entityManager;

    /**
     * @param SelectFactory<TEntity> $selectFactory
     */
    public function __construct(protected readonly ORMInterface $orm, SelectFactory $selectFactory)
    {
        parent::__construct($selectFactory);

        $this->entityManager = new EntityManager($orm);
    }

    /**
     * @throws RepositoryPersistException
     */
    public function persist(EntityInterface $entity, bool $cascade = true, bool $flush = false): void
    {
        $this->entityManager->persist(
            $entity,
            $cascade
        );

        if ($flush) {
            $this->flush();
        }
    }

    /**
     * @throws RepositoryPersistException
     */
    public function delete(EntityInterface $entity, bool $cascade = true, bool $flush = false): void
    {
        $this->entityManager->delete(
            $entity,
            $cascade
        );

        if ($flush) {
            $this->flush();
        }
    }

    /**
     * @throws RepositoryPersistException
     */
    public function persistAndFlush(EntityInterface $entity, bool $cascade = true): void
    {
        $this->persist($entity, $cascade, true);
    }

    /**
     * @throws RepositoryPersistException
     */
    public function deleteAndFlush(EntityInterface $entity, bool $cascade = true): void
    {
        $this->delete($entity, $cascade, true);
    }

    /**
     * @throws RepositoryPersistException
     */
    public function flush(): void
    {
        try {
            $this->entityManager->run();
        } catch (Throwable $e) {
            throw new RepositoryPersistException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
