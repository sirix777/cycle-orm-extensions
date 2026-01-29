<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Array;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Array\ArrayToDelimitedStringType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class ArrayToDelimitedStringTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new ArrayToDelimitedStringType();
        $context = new UncastContext('field', []);

        $this->assertEquals('a,b,c', $type->convertToDatabaseValue(['a', 'b', 'c'], $context));
        $this->assertNull($type->convertToDatabaseValue([], $context));
    }

    public function testConvertToDatabaseValueCustomDelimiter(): void
    {
        $type = new ArrayToDelimitedStringType('|');
        $context = new UncastContext('field', []);

        $this->assertEquals('a|b|c', $type->convertToDatabaseValue(['a', 'b', 'c'], $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new ArrayToDelimitedStringType();
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-an-array', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new ArrayToDelimitedStringType();
        $context = new CastContext('field', []);

        $this->assertEquals(['a', 'b', 'c'], $type->convertToPhpValue('a,b,c', $context));
        $this->assertEquals([], $type->convertToPhpValue(null, $context));
        $this->assertEquals([], $type->convertToPhpValue('', $context));
    }

    public function testConvertToPhpValueCustomDelimiter(): void
    {
        $type = new ArrayToDelimitedStringType('|');
        $context = new CastContext('field', []);

        $this->assertEquals(['a', 'b', 'c'], $type->convertToPhpValue('a|b|c', $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new ArrayToDelimitedStringType();
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(123, $context);
    }

    public function testConvertToPhpValueEmptyDelimiter(): void
    {
        $type = new ArrayToDelimitedStringType('');
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('a,b,c', $context);
    }
}
