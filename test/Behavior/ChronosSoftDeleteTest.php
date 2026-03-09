<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Behavior;

use Cycle\ORM\SchemaInterface;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Behavior\ChronosSoftDelete;
use Sirix\Cycle\Extension\Listener\ChronosSoftDeleteListener;

final class ChronosSoftDeleteTest extends TestCase
{
    public function testModifySchemaAddsListenerAndUpdatesColumn(): void
    {
        $schema = [
            SchemaInterface::COLUMNS => [
                'deletedAt' => 'deletedAt',
            ],
            SchemaInterface::LISTENERS => [],
        ];

        $modifier = new ChronosSoftDelete(field: 'deletedAt', column: 'deleted_at');
        $modifier->modifySchema($schema);

        $this->assertSame('deleted_at', $schema[SchemaInterface::COLUMNS]['deletedAt']);
        $this->assertSame(
            [[ChronosSoftDeleteListener::class, ['field' => 'deletedAt']]],
            $schema[SchemaInterface::LISTENERS],
        );
    }

    public function testWithRoleReturnsClone(): void
    {
        $modifier = new ChronosSoftDelete();
        $this->assertNotSame($modifier, $modifier->withRole('example'));
    }
}
