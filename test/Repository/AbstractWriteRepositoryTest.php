<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Repository;

use PHPUnit\Framework\MockObject\MockObject;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Domain\Contract\WriteRepositoryInterface;
use Sirix\Cycle\Extension\Exception\RepositoryPersistException;

/**
 * Tests for the WriteRepositoryInterface implementation.
 */
final class AbstractWriteRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @var MockObject&WriteRepositoryInterface<EntityInterface>
     */
    private WriteRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(WriteRepositoryInterface::class);
    }

    public function testPersistMethodExists(): void
    {
        $this->assertMethodExists(
            $this->repository,
            'persist',
            [$this->entity, true, false],
            ['object', 'bool', 'bool']
        );
    }

    public function testDeleteMethodExists(): void
    {
        $this->assertMethodExists(
            $this->repository,
            'delete',
            [$this->entity, true, false],
            ['object', 'bool', 'bool']
        );
    }

    public function testPersistAndFlushMethodExists(): void
    {
        $this->assertMethodExists(
            $this->repository,
            'persistAndFlush',
            [$this->entity, true],
            ['object', 'bool']
        );
    }

    public function testDeleteAndFlushMethodExists(): void
    {
        $this->assertMethodExists(
            $this->repository,
            'deleteAndFlush',
            [$this->entity, true],
            ['object', 'bool']
        );
    }

    public function testPersistCanThrowRepositoryPersistException(): void
    {
        $this->assertMethodThrowsException(
            $this->repository,
            'persist',
            RepositoryPersistException::class,
            [$this->entity, true, false]
        );
    }

    public function testDeleteCanThrowRepositoryPersistException(): void
    {
        $this->assertMethodThrowsException(
            $this->repository,
            'delete',
            RepositoryPersistException::class,
            [$this->entity, true, false]
        );
    }
}
