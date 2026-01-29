<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Example;

use Cycle\ORM\Select\Repository;
use DateTimeInterface;
use Sirix\Cycle\Extension\Factory\SelectFactory;
use Sirix\Cycle\Extension\Repository\AbstractReadRepository;

/**
 * Example of using the package with Cycle ORM's repository pattern.
 *
 * This example demonstrates how to create a read repository for entities
 * that use the traits provided by this package.
 */

/**
 * Read-only repository example.
 *
 * @extends Repository<AnnotatedEntityWithAttributesExample>
 */
class ReadRepositoryExample extends AbstractReadRepository
{
    public function __construct(SelectFactory $selectFactory)
    {
        parent::__construct($selectFactory);
    }

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
        return AnnotatedEntityWithAttributesExample::class;
    }
}
