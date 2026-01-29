<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated\Typecast;

use Cake\Chronos\Chronos;
use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionNamedType;
use ReflectionProperty;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\Typecast\HasChronosCreateDatetimeTypecastTrait;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateTimeStringType;

final class HasChronosCreateDatetimeTypecastTraitTest extends TestCase
{
    private object $traitObject;

    protected function setUp(): void
    {
        $this->traitObject = new class {
            use HasChronosCreateDatetimeTypecastTrait;
        };
    }

    public function testPropertyExists(): void
    {
        $this->assertTrue(property_exists($this->traitObject, 'createdAt'));
    }

    public function testColumnAttribute(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'createdAt');
        $attributes = $reflection->getAttributes(Column::class);

        $this->assertCount(1, $attributes);
        /** @var Column $column */
        $column = $attributes[0]->newInstance();

        $this->assertEquals('datetime', $column->getType());
    }

    public function testTypecastAttribute(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'createdAt');
        $attributes = $reflection->getAttributes(ChronosToDateTimeStringType::class);

        $this->assertCount(1, $attributes);
    }

    public function testPropertyType(): void
    {
        $reflection = new ReflectionProperty($this->traitObject, 'createdAt');
        $type = $reflection->getType();

        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals(Chronos::class, $type->getName());
    }
}
