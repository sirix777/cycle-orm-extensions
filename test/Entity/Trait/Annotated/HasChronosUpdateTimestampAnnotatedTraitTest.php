<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosUpdateTimestampAnnotatedTrait;

final class HasChronosUpdateTimestampAnnotatedTraitTest extends TestCase
{
    public function testPropertyHasColumnAnnotation(): void
    {
        $reflection = new ReflectionClass(HasChronosUpdateTimestampAnnotatedTrait::class);

        $property = $reflection->getProperty('updatedAt');
        $attributes = $property->getAttributes(Column::class);

        $this->assertCount(1, $attributes, 'Property should have exactly one Column attribute');

        $columnAttribute = $attributes[0]->newInstance();
        $this->assertEquals('int', $columnAttribute->getType(), 'Column type should be "int"');
        $this->assertTrue($columnAttribute->getAttributes()['unsigned'], 'Column should be unsigned');
    }

    public function testPropertyHasCorrectType(): void
    {
        $reflection = new ReflectionClass(HasChronosUpdateTimestampAnnotatedTrait::class);

        $property = $reflection->getProperty('updatedAt');
        $type = $property->getType();

        $this->assertNotNull($type);
        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(Chronos::class, $type->getName());
        $this->assertTrue($type->allowsNull(), 'Type should allow null');
    }

    public function testPropertyVisibility(): void
    {
        $reflection = new ReflectionClass(HasChronosUpdateTimestampAnnotatedTrait::class);

        $property = $reflection->getProperty('updatedAt');

        $this->assertTrue($property->isPrivate(), 'Property should be private');
    }

    public function testPropertyDefaultValue(): void
    {
        $reflection = new ReflectionClass(HasChronosUpdateTimestampAnnotatedTrait::class);

        $property = $reflection->getProperty('updatedAt');

        $this->assertTrue($property->hasDefaultValue(), 'Property should have a default value');
        $this->assertNull($property->getDefaultValue(), 'Default value should be null');
    }
}
