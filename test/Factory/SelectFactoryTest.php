<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Factory;

use Cycle\ORM\ORMInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionMethod;
use Sirix\Cycle\Extension\Factory\SelectFactory;
use stdClass;

final class SelectFactoryTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testInvokeThrowsExceptionForInvalidEntityClass(): void
    {
        $orm = $this->createMock(ORMInterface::class);

        $factory = new SelectFactory($orm);

        $reflectionMethod = new ReflectionMethod(SelectFactory::class, 'assertRoleAndCreateSelect');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid entity class');

        $reflectionMethod->invoke($factory, stdClass::class);
    }
}
