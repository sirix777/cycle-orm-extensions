<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Enum;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Enum\IntegerEnumType;
use ValueError;

enum TestIntegerEnum: int
{
    case One = 1;
    case Two = 2;
}

enum TestStringBackedEnumForIntegerType: string
{
    case One = 'one';
}

final class IntegerEnumTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new IntegerEnumType(TestIntegerEnum::class);
        $context = new UncastContext('field', []);

        $this->assertSame(1, $type->convertToDatabaseValue(TestIntegerEnum::One, $context));
        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalidValue(): void
    {
        $type = new IntegerEnumType(TestIntegerEnum::class);
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('1', $context);
    }

    public function testConvertToDatabaseValueInvalidEnumBackingType(): void
    {
        $type = new IntegerEnumType(TestStringBackedEnumForIntegerType::class);
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(TestStringBackedEnumForIntegerType::One, $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new IntegerEnumType(TestIntegerEnum::class);
        $context = new CastContext('field', []);

        $this->assertSame(TestIntegerEnum::One, $type->convertToPhpValue(1, $context));
        $this->assertSame(TestIntegerEnum::Two, $type->convertToPhpValue('2', $context));
        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalidValueType(): void
    {
        $type = new IntegerEnumType(TestIntegerEnum::class);
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('not-numeric', $context);
    }

    public function testConvertToPhpValueInvalidEnumValue(): void
    {
        $type = new IntegerEnumType(TestIntegerEnum::class);
        $context = new CastContext('field', []);

        $this->expectException(ValueError::class);
        $type->convertToPhpValue('999', $context);
    }
}
