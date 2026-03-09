<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Behavior;

use Cycle\ORM\SchemaInterface;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Behavior\ChronosCreatedAt;
use Sirix\Cycle\Extension\Listener\ChronosCreateListener;

final class ChronosCreatedAtTest extends TestCase
{
    public function testModifySchemaAddsListenerAndUpdatesColumn(): void
    {
        $schema = [
            SchemaInterface::COLUMNS => [
                'createdAt' => 'createdAt',
            ],
            SchemaInterface::LISTENERS => [],
        ];

        $modifier = new ChronosCreatedAt(field: 'createdAt', column: 'created_at');
        $modifier->modifySchema($schema);

        $this->assertSame('created_at', $schema[SchemaInterface::COLUMNS]['createdAt']);
        $this->assertSame(
            [[ChronosCreateListener::class, ['field' => 'createdAt']]],
            $schema[SchemaInterface::LISTENERS],
        );
    }

    public function testWithRoleReturnsClone(): void
    {
        $modifier = new ChronosCreatedAt();
        $this->assertNotSame($modifier, $modifier->withRole('example'));
    }
}
