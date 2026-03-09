<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Array;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Array\ArrayToJsonType;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

final class ArrayToJsonTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new ArrayToJsonType();
        $context = new UncastContext('field', []);

        $this->assertEquals('{"a":1,"b":2}', $type->convertToDatabaseValue(['a' => 1, 'b' => 2], $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new ArrayToJsonType();
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-an-array', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new ArrayToJsonType();
        $context = new CastContext('field', []);

        $this->assertEquals(['a' => 1, 'b' => 2], $type->convertToPhpValue('{"a":1,"b":2}', $context));
    }

    public function testConvertToPhpValueInvalidJson(): void
    {
        $type = new ArrayToJsonType();
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('invalid-json', $context);
    }
}
