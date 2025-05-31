<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasChronosCreateDatetimeAnnotatedTrait;

final class HasChronosCreateDatetimeAnnotatedTraitTest extends TestCase
{
    public function testPropertyHasColumnAnnotation(): void
    {
        $reflection = new ReflectionClass(HasChronosCreateDatetimeAnnotatedTrait::class);

        $property = $reflection->getProperty('createdAt');
        $attributes = $property->getAttributes(Column::class);

        $this->assertCount(1, $attributes, 'Property should have exactly one Column attribute');

        $columnAttribute = $attributes[0]->newInstance();
        $this->assertEquals('datetime', $columnAttribute->getType(), 'Column type should be "datetime"');
    }

    public function testPropertyHasCorrectType(): void
    {
        $reflection = new ReflectionClass(HasChronosCreateDatetimeAnnotatedTrait::class);

        $property = $reflection->getProperty('createdAt');
        $type = $property->getType();

        $this->assertNotNull($type);
        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(Chronos::class, $type->getName());
    }

    public function testPropertyVisibility(): void
    {
        $reflection = new ReflectionClass(HasChronosCreateDatetimeAnnotatedTrait::class);

        $property = $reflection->getProperty('createdAt');

        $this->assertTrue($property->isProtected(), 'Property should be protected');
    }
}
