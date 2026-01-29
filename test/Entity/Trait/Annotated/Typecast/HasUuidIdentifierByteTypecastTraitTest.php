<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated\Typecast;

use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasUuidIdentifierByteTypecastTrait;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToBytesType;

final class HasUuidIdentifierByteTypecastTraitTest extends TestCase
{
    public function testPropertyHasAnnotations(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierByteTypecastTrait::class);
        $property = $reflection->getProperty('uuid');

        $columnAttributes = $property->getAttributes(Column::class);
        $this->assertCount(1, $columnAttributes);
        $column = $columnAttributes[0]->newInstance();
        $this->assertEquals('binary(16)', $column->getType());
        $this->assertTrue($column->isPrimary());

        $typecastAttributes = $property->getAttributes(UuidToBytesType::class);
        $this->assertCount(1, $typecastAttributes);
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionClass(HasUuidIdentifierByteTypecastTrait::class);
        $property = $reflection->getProperty('uuid');
        $type = $property->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(UuidInterface::class, $type->getName());
    }
}
