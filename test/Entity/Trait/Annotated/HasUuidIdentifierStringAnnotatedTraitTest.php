<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated;

use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasUuidIdentifierStringAnnotatedTrait;

final class HasUuidIdentifierStringAnnotatedTraitTest extends TestCase
{
    public function testPropertyHasColumnAnnotation(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierStringAnnotatedTrait::class);

        $property = $reflection->getProperty('uuid');
        $attributes = $property->getAttributes(Column::class);

        $this->assertCount(1, $attributes);

        $columnAttribute = $attributes[0]->newInstance();
        $this->assertEquals('string(36)', $columnAttribute->getType());
        $this->assertTrue($columnAttribute->isPrimary());
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierStringAnnotatedTrait::class);
        $property = $reflection->getProperty('uuid');
        $type = $property->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(UuidInterface::class, $type->getName());
    }
}
