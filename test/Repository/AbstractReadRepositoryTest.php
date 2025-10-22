<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Repository;

use PHPUnit\Framework\MockObject\MockObject;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Domain\Contract\ReadRepositoryInterface;
use Sirix\Cycle\Extension\Exception\EntityNotFoundException;

/**
 * Tests for the ReadRepositoryInterface implementation.
 */
final class AbstractReadRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @var MockObject&ReadRepositoryInterface<EntityInterface>
     */
    private ReadRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->createMock(ReadRepositoryInterface::class);
        $this->configureRepositoryMock();
    }

    public function testFindByIdentifierWithIntReturnsEntity(): void
    {
        $result = $this->repository->findByIdentifier(1);

        $this->assertEntityResult($this->entity, $result);
    }

    public function testFindByIdentifierWithUuidReturnsEntity(): void
    {
        $uuid = $this->createTestUuid();

        $result = $this->repository->findByIdentifier($uuid);

        $this->assertEntityResult($this->entity, $result);
    }

    public function testFindByIdentifierReturnsNullWhenNotFound(): void
    {
        $result = $this->repository->findByIdentifier(999);

        $this->assertNullResult($result);
    }

    public function testGetByIdentifierReturnsEntityWhenFound(): void
    {
        $result = $this->repository->getByIdentifier(1);

        $this->assertEntityResult($this->entity, $result);
    }

    public function testGetByIdentifierThrowsExceptionWhenNotFound(): void
    {
        $this->expectException(EntityNotFoundException::class);
        $this->repository->getByIdentifier(999);
    }

    /**
     * Configures the repository mock with the default behavior.
     */
    private function configureRepositoryMock(): void
    {
        $this->repository->method('findByIdentifier')
            ->willReturnCallback(function($id) {
                if (1 === $id || $id instanceof UuidInterface) {
                    return $this->entity;
                }

                return null;
            })
        ;

        $this->repository->method('getByIdentifier')
            ->willReturnCallback(function($id) {
                if (1 === $id || $id instanceof UuidInterface) {
                    return $this->entity;
                }

                throw new EntityNotFoundException('Entity not found');
            })
        ;
    }
}
