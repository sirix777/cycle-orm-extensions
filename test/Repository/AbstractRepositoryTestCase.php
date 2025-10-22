<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Repository;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Domain\Contract\EntityInterface;
use Throwable;
use function gettype;
use function is_object;

/**
 * Base test case for repository tests.
 *
 * This abstract class provides common functionality for testing repositories.
 */
abstract class AbstractRepositoryTestCase extends TestCase
{
    protected EntityInterface $entity;

    protected function setUp(): void
    {
        $this->entity = $this->createMock(EntityInterface::class);
    }

    /**
     * Creates a UUID for testing.
     */
    protected function createTestUuid(): UuidInterface
    {
        return Uuid::uuid4();
    }

    /**
     * Asserts that the result is the same as the expected entity.
     */
    protected function assertEntityResult(EntityInterface $expected, ?EntityInterface $actual): void
    {
        $this->assertSame($expected, $actual);
    }

    /**
     * Asserts that the result is null.
     */
    protected function assertNullResult(?EntityInterface $actual): void
    {
        $this->assertNull($actual);
    }

    /**
     * Asserts that a method exists and can be called with the expected parameters.
     *
     * @param MockObject    $mock           The mock object
     * @param string        $methodName     The method name to test
     * @param array<mixed>  $parameters     The parameters to pass to the method
     * @param array<string> $parameterTypes The expected parameter types (e.g., ['object', 'bool', 'bool'])
     */
    protected function assertMethodExists(MockObject $mock, string $methodName, array $parameters, array $parameterTypes): void
    {
        $withParams = [];

        foreach ($parameters as $index => $param) {
            if (is_object($param)) {
                $withParams[] = $this->identicalTo($param);
            } else {
                $withParams[] = $this->isType($this->normalizeType($parameterTypes[$index] ?? gettype($param)));
            }
        }

        $mock->expects($this->once())
            ->method($methodName)
            ->with(...$withParams)
        ;

        $mock->{$methodName}(...$parameters);
    }

    /**
     * Asserts that a method throws an exception.
     *
     * @param MockObject              $mock           The mock object
     * @param string                  $methodName     The method name to test
     * @param class-string<Throwable> $exceptionClass The expected exception class
     * @param array<mixed>            $parameters     The parameters to pass to the method
     */
    protected function assertMethodThrowsException(MockObject $mock, string $methodName, string $exceptionClass, array $parameters): void
    {
        $exception = new $exceptionClass('Test exception');

        $mock->method($methodName)
            ->willThrowException($exception)
        ;

        $this->expectException($exceptionClass);

        $mock->{$methodName}(...$parameters);
    }

    /**
     * Normalizes a type string to one of the valid types accepted by PHPUnit's isType() method.
     *
     * @param string $type The type to normalize
     *
     * @return 'array'|'bool'|'callable'|'float'|'int'|'iterable'|'null'|'numeric'|'object'|'resource (closed)'|'resource'|'scalar'|'string' A valid type for PHPUnit's isType() method
     */
    private function normalizeType(string $type): string
    {
        return match ($type) {
            'boolean' => 'bool',
            'integer' => 'int',
            'double', 'real' => 'float',
            'object', 'array', 'string', 'float', 'int', 'bool', 'null',
            'numeric', 'callable', 'iterable', 'scalar', 'resource', 'resource (closed)' => $type,
            default => 'string', // Default to string for unknown types
        };
    }
}
