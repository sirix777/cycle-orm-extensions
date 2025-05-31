<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait;

use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Entity\Trait\HasIdIdentifierTrait;

final class HasIdIdentifierTraitTest extends TestCase
{
    public function testGetAndSetIdentifier(): void
    {
        $entity = new class {
            use HasIdIdentifierTrait;
        };

        $id = 123;
        $entity->setIdentifier($id);

        $this->assertSame($id, $entity->getIdentifier());
    }

    public function testIdentifierIsNullWhenNotInitialized(): void
    {
        $entity = new class {
            use HasIdIdentifierTrait;
        };

        $this->assertNull($entity->getIdentifier());
    }

    public function testIdentifierPropertyType(): void
    {
        $entity = new class {
            use HasIdIdentifierTrait;
        };

        $id = 123;
        $entity->setIdentifier($id);

        $this->assertIsInt($entity->getIdentifier());
    }
}
