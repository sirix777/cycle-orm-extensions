<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosUpdateDatetimeTypecastTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateTimeStringType;

final class HasChronosUpdateDatetimeTypecastTraitTest extends TestCase
{
    public function testPropertyHasAnnotations(): void
    {
        $reflection = new ReflectionClass(HasChronosUpdateDatetimeTypecastTrait::class);
        $property = $reflection->getProperty('updatedAt');

        $columnAttributes = $property->getAttributes(Column::class);
        $this->assertCount(1, $columnAttributes);
        $column = $columnAttributes[0]->newInstance();
        $this->assertEquals('datetime', $column->getType());
        $this->assertTrue($column->isNullable());

        $typecastAttributes = $property->getAttributes(ChronosToDateTimeStringType::class);
        $this->assertCount(1, $typecastAttributes);
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionClass(HasChronosUpdateDatetimeTypecastTrait::class);
        $property = $reflection->getProperty('updatedAt');
        $type = $property->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(Chronos::class, $type->getName());
        $this->assertTrue($type->allowsNull());
    }
}
