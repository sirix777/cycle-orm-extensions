<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Entity\Trait;

use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Entity\Trait\HasChronosDeleteTrait;

final class HasChronosDeleteTraitTest extends TestCase
{
    public function testGetAndSetDeletedAt(): void
    {
        $entity = new class {
            use HasChronosDeleteTrait;
        };

        $now = Chronos::now();
        $entity->setDeletedAt($now);

        $this->assertSame($now, $entity->getDeletedAt());
    }

    public function testDeletedAtPropertyIsNullByDefault(): void
    {
        $entity = new class {
            use HasChronosDeleteTrait;
        };

        $this->assertNull($entity->getDeletedAt());
    }

    public function testDeletedAtPropertyType(): void
    {
        $entity = new class {
            use HasChronosDeleteTrait;
        };

        $now = Chronos::now();
        $entity->setDeletedAt($now);

        $this->assertInstanceOf(Chronos::class, $entity->getDeletedAt());
    }
}
