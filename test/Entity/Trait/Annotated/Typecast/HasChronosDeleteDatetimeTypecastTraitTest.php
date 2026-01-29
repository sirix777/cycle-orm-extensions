<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionNamedType;
use ReflectionProperty;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosDeleteDatetimeTypecastTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateTimeStringType;

final class HasChronosDeleteDatetimeTypecastTraitTest extends TestCase
{
    private object $traitObject;

    protected function setUp(): void
    {
        $this->traitObject = new class {
            use HasChronosDeleteDatetimeTypecastTrait;
        };
    }

    public function testPropertyExists(): void
    {
        $this->assertTrue(property_exists($this->traitObject, 'deletedAt'));
    }

    public function testColumnAttribute(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'deletedAt');
        $attributes = $reflection->getAttributes(Column::class);

        $this->assertCount(1, $attributes);
        /** @var Column $column */
        $column = $attributes[0]->newInstance();

        $this->assertEquals('datetime', $column->getType());
        $this->assertTrue($column->isNullable());
    }

    public function testTypecastAttribute(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'deletedAt');
        $attributes = $reflection->getAttributes(ChronosToDateTimeStringType::class);

        $this->assertCount(1, $attributes);
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'deletedAt');
        $type = $reflection->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(Chronos::class, $type->getName());
        $this->assertTrue($type->allowsNull());
    }
}
