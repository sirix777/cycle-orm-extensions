<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\ORM\Select\Repository;
use DateTimeInterface;
use Sirix\Cycle\Extension\Repository\AbstractWriteRepository;

/**
 * Example of using the package with Cycle ORM's repository pattern.
 *
 * This example demonstrates how to create a writing repository for entities
 * that use the traits provided by this package.
 */

/**
 * A writing repository example.
 *
 * @extends Repository<AnnotatedEntityExample>
 */
class WriteRepositoryExample extends AbstractWriteRepository
{
    /**
     * Example of finding entities created after a certain date.
     *
     * @param DateTimeInterface $date The date to compare against
     *
     * @return array The found entities
     */
    public function findUsersCreatedAfter(DateTimeInterface $date): array
    {
        $select = $this->select()
            ->where('createdAt', '>', $date->getTimestamp())
        ;

        return $select->fetchAll();
    }

    protected function getEntityClass(): string
    {
        return AnnotatedEntityExample::class;
    }
}
