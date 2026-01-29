<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosCreateTimestampTypecastTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToTimestampType;

final class HasChronosCreateTimestampTypecastTraitTest extends TestCase
{
    public function testPropertyHasAnnotations(): void
    {
        $reflection = new ReflectionClass(HasChronosCreateTimestampTypecastTrait::class);
        $property = $reflection->getProperty('createdAt');

        $columnAttributes = $property->getAttributes(Column::class);
        $this->assertCount(1, $columnAttributes);
        $column = $columnAttributes[0]->newInstance();
        $this->assertEquals('int', $column->getType());

        $typecastAttributes = $property->getAttributes(ChronosToTimestampType::class);
        $this->assertCount(1, $typecastAttributes);
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionClass(HasChronosCreateTimestampTypecastTrait::class);
        $property = $reflection->getProperty('createdAt');
        $type = $property->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(Chronos::class, $type->getName());
    }
}
