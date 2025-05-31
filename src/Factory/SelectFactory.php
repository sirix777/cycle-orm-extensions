<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Factory;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use InvalidArgumentException;
use Sirix\Cycle\Extension\Contract\EntityInterface;

use function is_a;

/**
 * @template TEntity of EntityInterface
 */
final class SelectFactory
{
    public function __construct(private readonly ORMInterface $orm) {}

    /**
     * @param class-string<TEntity> $role
     *
     * @return Select<TEntity>
     */
    public function __invoke(string $role): Select
    {
        return $this->assertRoleAndCreateSelect($role);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $role
     *
     * @return Select<T>
     */
    private function assertRoleAndCreateSelect(string $role): Select
    {
        if (! is_a($role, EntityInterface::class, true)) {
            throw new InvalidArgumentException('Invalid entity class');
        }

        // @phpstan-ignore-next-line
        return new Select($this->orm, $role);
    }
}
