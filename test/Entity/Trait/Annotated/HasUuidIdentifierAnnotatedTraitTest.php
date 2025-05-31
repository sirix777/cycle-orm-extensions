<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated;

use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasUuidIdentifierAnnotatedTrait;

final class HasUuidIdentifierAnnotatedTraitTest extends TestCase
{
    public function testPropertyHasColumnAnnotation(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierAnnotatedTrait::class);

        $property = $reflection->getProperty('uuid');
        $attributes = $property->getAttributes(Column::class);

        $this->assertCount(1, $attributes, 'Property should have exactly one Column attribute');

        $columnAttribute = $attributes[0]->newInstance();
        $this->assertEquals('uuid', $columnAttribute->getType(), 'Column type should be "uuid"');
    }

    public function testPropertyHasCorrectType(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierAnnotatedTrait::class);

        $property = $reflection->getProperty('uuid');
        $type = $property->getType();

        $this->assertNotNull($type);
        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(UuidInterface::class, $type->getName());
    }

    public function testPropertyVisibility(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierAnnotatedTrait::class);

        $property = $reflection->getProperty('uuid');

        $this->assertTrue($property->isProtected(), 'Property should be protected');
    }
}
