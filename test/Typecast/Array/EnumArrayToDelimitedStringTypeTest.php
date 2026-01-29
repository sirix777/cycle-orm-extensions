<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Array;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Array\EnumArrayToDelimitedStringType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

enum TestIntEnum: int
{
    case ONE = 1;
    case TWO = 2;
}

final class EnumArrayToDelimitedStringTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new EnumArrayToDelimitedStringType(TestIntEnum::class);
        $context = new UncastContext('field', []);

        $this->assertEquals('1,2', $type->convertToDatabaseValue([TestIntEnum::ONE, TestIntEnum::TWO], $context));
        $this->assertNull($type->convertToDatabaseValue([], $context));
        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new EnumArrayToDelimitedStringType(TestIntEnum::class);
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-an-array', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new EnumArrayToDelimitedStringType(TestIntEnum::class);
        $context = new CastContext('field', []);

        $this->assertEquals([TestIntEnum::ONE, TestIntEnum::TWO], $type->convertToPhpValue('1,2', $context));
        $this->assertEquals([], $type->convertToPhpValue(null, $context));
        $this->assertEquals([], $type->convertToPhpValue('', $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new EnumArrayToDelimitedStringType(TestIntEnum::class);
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(123, $context);
    }
}
