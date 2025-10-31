<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Behavior;

use Cycle\ORM\SchemaInterface;
use Cycle\Schema\Registry;
use Cycle\Database\DatabaseProviderInterface;
use Cycle\Database\DatabaseInterface;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Behavior\EventListeners;
use stdClass;

final class EventListenersTest extends TestCase
{
    public function testModifySchemaAddsClassStringListeners(): void
    {
        $initial = [SchemaInterface::LISTENERS => [DateTime::class]];
        $schema = $initial;

        $listeners = new EventListeners([
            stdClass::class,
            Exception::class,
        ]);

        $listeners->modifySchema($schema);

        $this->assertArrayHasKey(SchemaInterface::LISTENERS, $schema);
        $this->assertSame([
            DateTime::class,
            stdClass::class,
            Exception::class,
        ], $schema[SchemaInterface::LISTENERS]);

    }

    public function testModifySchemaCollapsesEmptyArgsTupleToClassString(): void
    {
        $schema = [SchemaInterface::LISTENERS => []];

        $listeners = new EventListeners([
            [DummyListenerA::class, []],
        ]);

        $listeners->modifySchema($schema);

        $this->assertSame([
            DummyListenerA::class,
        ], $schema[SchemaInterface::LISTENERS]);
    }

    public function testModifySchemaKeepsNonEmptyArgsTuple(): void
    {
        $schema = [SchemaInterface::LISTENERS => []];

        $args = ['foo' => 123, 'bar' => 'baz'];
        $listeners = new EventListeners([
            [DummyListenerB::class, $args],
        ]);

        $listeners->modifySchema($schema);

        $this->assertSame([
            [DummyListenerB::class, $args],
        ], $schema[SchemaInterface::LISTENERS]);
    }

    public function testComputeAndRenderAreNoOps(): void
    {
        $dbal = $this->createMock(DatabaseProviderInterface::class);
        $db = $this->createMock(DatabaseInterface::class);
        $dbal->method('database')->willReturn($db);
        $registry = new Registry($dbal);

        $listeners = new EventListeners([
            stdClass::class,
        ]);

        // Should not throw and not interact in any specific way
        $this->expectNotToPerformAssertions();
        $listeners->compute($registry);
        $listeners->render($registry);
    }

    public function testWithRoleReturnsCloneWithoutChangingBehavior(): void
    {
        $schema1 = [SchemaInterface::LISTENERS => []];
        $schema2 = [SchemaInterface::LISTENERS => []];

        $original = new EventListeners([
            DummyListenerA::class,
            [DummyListenerB::class, ['x' => 1]],
        ]);

        $clone = $original->withRole('any-role');

        $this->assertNotSame($original, $clone);

        $original->modifySchema($schema1);
        $clone->modifySchema($schema2);

        $this->assertSame($schema1, $schema2);
    }
}

// Simple dummy listener classes for testing purposes
final class DummyListenerA {}
final class DummyListenerB {}
