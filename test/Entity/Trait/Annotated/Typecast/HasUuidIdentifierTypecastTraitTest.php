<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated\Typecast;

use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use ReflectionNamedType;
use ReflectionProperty;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasUuidIdentifierTypecastTrait;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToStringType;

final class HasUuidIdentifierTypecastTraitTest extends TestCase
{
    private object $traitObject;

    protected function setUp(): void
    {
        $this->traitObject = new class {
            use HasUuidIdentifierTypecastTrait;
        };
    }

    public function testPropertyExists(): void
    {
        $this->assertTrue(property_exists($this->traitObject, 'uuid'));
    }

    public function testColumnAttribute(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'uuid');
        $attributes = $reflection->getAttributes(Column::class);

        $this->assertCount(1, $attributes);
        /** @var Column $column */
        $column = $attributes[0]->newInstance();

        $this->assertEquals('uuid', $column->getType());
        $this->assertTrue($column->isPrimary());
    }

    public function testTypecastAttribute(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'uuid');
        $attributes = $reflection->getAttributes(UuidToStringType::class);

        $this->assertCount(1, $attributes);
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'uuid');
        $type = $reflection->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(UuidInterface::class, $type->getName());
    }
}
