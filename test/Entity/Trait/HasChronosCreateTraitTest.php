<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait;

use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosCreateTrait;

final class HasChronosCreateTraitTest extends TestCase
{
    public function testGetAndSetCreatedAt(): void
    {
        $entity = new class {
            use HasChronosCreateTrait;
        };

        $now = Chronos::now();
        $entity->setCreatedAt($now);

        $this->assertSame($now, $entity->getCreatedAt());
    }

    public function testCreatedAtPropertyType(): void
    {
        $entity = new class {
            use HasChronosCreateTrait;
        };

        $now = Chronos::now();
        $entity->setCreatedAt($now);

        $this->assertInstanceOf(Chronos::class, $entity->getCreatedAt());
    }
}
