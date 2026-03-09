<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Handler;

use Cycle\ORM\SchemaInterface;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Array\ArrayToDelimitedStringType;
use Sirix\Cycle\Extension\Typecast\Boolean\BooleanToIntType;
use Sirix\Cycle\Extension\Typecast\Handler\AttributeTypecastHandler;

final class AttributeTypecastHandlerTest extends TestCase
{
    public function testSetRulesRemovesRulesForAnnotatedProperties(): void
    {
        $handler = new AttributeTypecastHandler(
            $this->mockSchema('test-role', AttributeTypecastEntityStub::class),
            'test-role',
        );

        $rules = [
            'tags' => 'string',
            'active' => 'bool',
            'name' => 'string',
        ];

        $this->assertSame(['name' => 'string'], $handler->setRules($rules));
    }

    public function testCastConvertsAnnotatedPropertiesOnly(): void
    {
        $handler = new AttributeTypecastHandler(
            $this->mockSchema('test-role', AttributeTypecastEntityStub::class),
            'test-role',
        );

        $result = $handler->cast([
            'tags' => 'foo|bar',
            'active' => 1,
            'name' => 'Alice',
        ]);

        $this->assertSame(['foo', 'bar'], $result['tags']);
        $this->assertTrue($result['active']);
        $this->assertSame('Alice', $result['name']);
    }

    public function testUncastConvertsAnnotatedPropertiesOnly(): void
    {
        $handler = new AttributeTypecastHandler(
            $this->mockSchema('test-role', AttributeTypecastEntityStub::class),
            'test-role',
        );

        $result = $handler->uncast([
            'tags' => ['foo', 'bar'],
            'active' => true,
            'name' => 'Alice',
        ]);

        $this->assertSame('foo|bar', $result['tags']);
        $this->assertSame(1, $result['active']);
        $this->assertSame('Alice', $result['name']);
    }

    public function testNoEntityClassLeavesRulesAndDataUnchanged(): void
    {
        $handler = new AttributeTypecastHandler(
            $this->mockSchema('test-role', 'Missing\\Entity'),
            'test-role',
        );

        $rules = ['tags' => 'string'];
        $this->assertSame($rules, $handler->setRules($rules));

        $data = ['tags' => 'foo|bar', 'active' => 1];
        $this->assertSame($data, $handler->cast($data));
        $this->assertSame($data, $handler->uncast($data));
    }

    private function mockSchema(string $role, string $entityClass): SchemaInterface
    {
        $schema = $this->createMock(SchemaInterface::class);
        $schema
            ->method('define')
            ->willReturnCallback(
                static function (string $requestedRole, int $field) use ($role, $entityClass): ?string {
                    if ($requestedRole === $role && $field === SchemaInterface::ENTITY) {
                        return $entityClass;
                    }

                    return null;
                },
            );

        return $schema;
    }
}

final class AttributeTypecastEntityStub
{
    /** @var array<int, string> */
    #[ArrayToDelimitedStringType(delimiter: '|')]
    private array $tags = [];

    #[BooleanToIntType]
    private bool $active = false;

    /**
     * @return array{0: array<int, string>, 1: bool}
     */
    public function readForStaticAnalysis(): array
    {
        return [$this->tags, $this->active];
    }
}
