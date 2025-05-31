<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait\Annotated;

use Cycle\Annotated\Annotation\Column;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionNamedType;
use Sirix\Cycle\Extension\Entity\Trait\Annotated\HasIdIdentifierAnnotatedTrait;

final class HasIdIdentifierAnnotatedTraitTest extends TestCase
{
    public function testPropertyHasColumnAnnotation(): void
    {
        $reflection = new ReflectionClass(HasIdIdentifierAnnotatedTrait::class);

        $property = $reflection->getProperty('id');
        $attributes = $property->getAttributes(Column::class);

        $this->assertCount(1, $attributes, 'Property should have exactly one Column attribute');

        $columnAttribute = $attributes[0]->newInstance();
        $this->assertEquals('bigPrimary', $columnAttribute->getType(), 'Column type should be "bigPrimary"');
    }

    public function testPropertyHasCorrectType(): void
    {
        $reflection = new ReflectionClass(HasIdIdentifierAnnotatedTrait::class);

        $property = $reflection->getProperty('id');
        $type = $property->getType();

        $this->assertNotNull($type);
        $this->assertInstanceOf(ReflectionNamedType::class, $type);
        $this->assertEquals('int', $type->getName());
        $this->assertTrue($type->allowsNull(), 'Type should allow null');
    }

    public function testPropertyVisibility(): void
    {
        $reflection = new ReflectionClass(HasIdIdentifierAnnotatedTrait::class);

        $property = $reflection->getProperty('id');

        $this->assertTrue($property->isProtected(), 'Property should be protected');
    }
}
