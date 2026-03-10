<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Enum;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Enum\StringEnumType;
use ValueError;

enum TestStringEnum: string
{
    case Draft = 'draft';
    case Published = 'published';
}

enum TestIntBackedEnumForStringType: int
{
    case One = 1;
}

final class StringEnumTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new StringEnumType(TestStringEnum::class);
        $context = new UncastContext('field', []);

        $this->assertSame('draft', $type->convertToDatabaseValue(TestStringEnum::Draft, $context));
        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalidValue(): void
    {
        $type = new StringEnumType(TestStringEnum::class);
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('draft', $context);
    }

    public function testConvertToDatabaseValueInvalidEnumBackingType(): void
    {
        $type = new StringEnumType(TestIntBackedEnumForStringType::class);
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue(TestIntBackedEnumForStringType::One, $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new StringEnumType(TestStringEnum::class);
        $context = new CastContext('field', []);

        $this->assertSame(TestStringEnum::Published, $type->convertToPhpValue('published', $context));
        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalidValueType(): void
    {
        $type = new StringEnumType(TestStringEnum::class);
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(1, $context);
    }

    public function testConvertToPhpValueInvalidEnumValue(): void
    {
        $type = new StringEnumType(TestStringEnum::class);
        $context = new CastContext('field', []);

        $this->expectException(ValueError::class);
        $type->convertToPhpValue('archived', $context);
    }
}
