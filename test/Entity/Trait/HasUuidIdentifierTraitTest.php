<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Contract\EntityInterface;
use Sirix\Cycle\Extension\Entity\Trait\HasUuidIdentifierTrait;

final class HasUuidIdentifierTraitTest extends TestCase
{
    /**
     * Entity with HasUuidIdentifierTrait.
     */
    private TestEntityWithUuidTrait $entity;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entity = new TestEntityWithUuidTrait();
    }

    public function testGetAndSetIdentifier(): void
    {
        $uuid = Uuid::uuid4();
        $this->entity->setIdentifier($uuid);

        $this->assertSame($uuid, $this->entity->getIdentifier());
    }

    public function testIdentifierPropertyType(): void
    {
        $uuid = Uuid::uuid4();
        $this->entity->setIdentifier($uuid);

        $this->assertInstanceOf(UuidInterface::class, $this->entity->getIdentifier());
    }

    public function testNextMethodGeneratesUuid(): void
    {
        $uuid = $this->entity->next();

        $this->assertUuid($uuid);
    }

    public function testNextMethodWithVersion4(): void
    {
        $uuid = $this->entity->next(4);

        $this->assertUuid($uuid, 4);
    }

    public function testNextMethodWithDefaultVersion7(): void
    {
        $uuid = $this->entity->next();

        $this->assertUuid($uuid, 7);
    }

    /**
     * Assert that a value is a UUID of the expected version.
     */
    private function assertUuid(?UuidInterface $uuid, ?int $expectedVersion = null): void
    {
        $this->assertInstanceOf(UuidInterface::class, $uuid);

        if (null !== $expectedVersion) {
            $this->assertEquals($expectedVersion, $uuid->getVersion());
        }
    }
}

/**
 * Test-specific class that uses the trait directly.
 */
class TestEntityWithUuidTrait implements EntityInterface
{
    use HasUuidIdentifierTrait;
}
