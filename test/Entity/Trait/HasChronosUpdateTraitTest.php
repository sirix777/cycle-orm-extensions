<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait;

use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosUpdateTrait;

final class HasChronosUpdateTraitTest extends TestCase
{
    public function testGetAndSetUpdatedAt(): void
    {
        $entity = new class {
            use HasChronosUpdateTrait;
        };

        $now = Chronos::now();
        $entity->setUpdatedAt($now);

        $this->assertSame($now, $entity->getUpdatedAt());
    }

    public function testUpdatedAtPropertyIsNullByDefault(): void
    {
        $entity = new class {
            use HasChronosUpdateTrait;
        };

        $this->assertNull($entity->getUpdatedAt());
    }

    public function testUpdatedAtPropertyType(): void
    {
        $entity = new class {
            use HasChronosUpdateTrait;
        };

        $now = Chronos::now();
        $entity->setUpdatedAt($now);

        $this->assertInstanceOf(Chronos::class, $entity->getUpdatedAt());
    }
}
