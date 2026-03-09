<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Behavior;

use Cycle\ORM\SchemaInterface;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Behavior\ChronosUpdatedAt;
use Sirix\Cycle\Extension\Listener\ChronosUpdateListener;

final class ChronosUpdatedAtTest extends TestCase
{
    public function testModifySchemaAddsListenerWithNullableAndUpdatesColumn(): void
    {
        $schema = [
            SchemaInterface::COLUMNS => [
                'updatedAt' => 'updatedAt',
            ],
            SchemaInterface::LISTENERS => [],
        ];

        $modifier = new ChronosUpdatedAt(field: 'updatedAt', column: 'updated_at', nullable: true);
        $modifier->modifySchema($schema);

        $this->assertSame('updated_at', $schema[SchemaInterface::COLUMNS]['updatedAt']);
        $this->assertSame(
            [[ChronosUpdateListener::class, ['field' => 'updatedAt', 'nullable' => true]]],
            $schema[SchemaInterface::LISTENERS],
        );
    }

    public function testWithRoleReturnsClone(): void
    {
        $modifier = new ChronosUpdatedAt();
        $this->assertNotSame($modifier, $modifier->withRole('example'));
    }
}
