<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Repository;

use Cycle\ORM\Select\Repository;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Domain\Contract\ReadRepositoryInterface;
use Sirix\Cycle\Extension\Exception\EntityNotFoundException;

use function is_int;

/**
 * @template TEntity of EntityInterface
 *
 * @extends Repository<TEntity>
 *
 * @implements ReadRepositoryInterface<TEntity>
 */
abstract class AbstractReadRepository extends Repository implements ReadRepositoryInterface
{
    protected const USE_BINARY_UUID = true;

    public function findByIdentifier(int|UuidInterface $identifier): ?EntityInterface
    {
        return $this->findByPk($this->normalizePrimaryKey($identifier));
    }

    public function getByIdentifier(int|UuidInterface $identifier): EntityInterface
    {
        $entity = $this->findByIdentifier($identifier);

        if (! $entity instanceof EntityInterface) {
            throw new EntityNotFoundException('Entity not found');
        }

        return $entity;
    }

    private function normalizePrimaryKey(int|UuidInterface $identifier): int|string
    {
        if (is_int($identifier)) {
            return $identifier;
        }

        return static::USE_BINARY_UUID
            ? $identifier->getBytes()
            : $identifier->toString();
    }
}
