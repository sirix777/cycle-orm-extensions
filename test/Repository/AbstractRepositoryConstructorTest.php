<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Repository;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Select;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Sirix\Cycle\Extension\Exception\EntityNotFoundException;
use Sirix\Cycle\Extension\Repository\AbstractReadRepository;
use Sirix\Cycle\Extension\Repository\AbstractWriteRepository;

final class AbstractRepositoryConstructorTest extends TestCase
{
    public function testReadRepositoryConstructWithSelect(): void
    {
        $select = $this->createMock(Select::class);

        $repository = new class($select) extends AbstractReadRepository {};

        $this->assertInstanceOf(AbstractReadRepository::class, $repository);
    }

    public function testReadRepositoryFindByIdentifierWithInt(): void
    {
        $entity = $this->createMock(EntityInterface::class);

        $select = $this->createMock(Select::class);
        $select->method('wherePK')->willReturnSelf();
        $select->method('fetchOne')->willReturn($entity);

        $repository = new class($select) extends AbstractReadRepository {};

        $result = $repository->findByIdentifier(1);

        $this->assertSame($entity, $result);
    }

    public function testReadRepositoryFindByIdentifierReturnsNullWhenNotFound(): void
    {
        $select = $this->createMock(Select::class);
        $select->method('wherePK')->willReturnSelf();
        $select->method('fetchOne')->willReturn(null);

        $repository = new class($select) extends AbstractReadRepository {};

        $result = $repository->findByIdentifier(999);

        $this->assertNull($result);
    }

    public function testReadRepositoryGetByIdentifierReturnsEntity(): void
    {
        $entity = $this->createMock(EntityInterface::class);

        $select = $this->createMock(Select::class);
        $select->method('wherePK')->willReturnSelf();
        $select->method('fetchOne')->willReturn($entity);

        $repository = new class($select) extends AbstractReadRepository {};

        $result = $repository->getByIdentifier(1);

        $this->assertSame($entity, $result);
    }

    public function testReadRepositoryGetByIdentifierThrowsExceptionWhenNotFound(): void
    {
        $select = $this->createMock(Select::class);
        $select->method('wherePK')->willReturnSelf();
        $select->method('fetchOne')->willReturn(null);

        $repository = new class($select) extends AbstractReadRepository {};

        $this->expectException(EntityNotFoundException::class);
        $repository->getByIdentifier(999);
    }

    public function testReadRepositoryHasNoGetEntityClassMethod(): void
    {
        $reflection = new ReflectionClass(AbstractReadRepository::class);

        $this->assertFalse($reflection->hasMethod('getEntityClass'));
    }

    public function testWriteRepositoryConstructorSignature(): void
    {
        $reflection = new ReflectionClass(AbstractWriteRepository::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);

        $parameters = $constructor->getParameters();
        $this->assertCount(2, $parameters);
        $this->assertSame('select', $parameters[0]->getName());
        $this->assertSame('orm', $parameters[1]->getName());
    }

    public function testWriteRepositoryHasNoGetEntityClassMethod(): void
    {
        $reflection = new ReflectionClass(AbstractWriteRepository::class);

        $this->assertFalse($reflection->hasMethod('getEntityClass'));
    }

    public function testWriteRepositoryConstructorAcceptsSelectAndOrmInterface(): void
    {
        $reflection = new ReflectionClass(AbstractWriteRepository::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);

        $parameters = $constructor->getParameters();

        $selectType = $parameters[0]->getType();
        $this->assertInstanceOf(ReflectionNamedType::class, $selectType);
        $this->assertSame(Select::class, $selectType->getName());

        $ormType = $parameters[1]->getType();
        $this->assertInstanceOf(ReflectionNamedType::class, $ormType);
        $this->assertSame(ORMInterface::class, $ormType->getName());
    }
}
