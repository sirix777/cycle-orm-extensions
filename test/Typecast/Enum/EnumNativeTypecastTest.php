<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Enum;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Enum\EnumNativeTypecast;

enum NativeStringEnum: string
{
    case Draft = 'draft';
    case Published = 'published';
}

enum NativeIntegerEnum: int
{
    case Low = 1;
    case High = 2;
}

enum NativeUnitEnum
{
    case Value;
}

final class EnumNativeTypecastTest extends TestCase
{
    public function testToStringEnum(): void
    {
        $this->assertNull(EnumNativeTypecast::toStringEnum(null, NativeStringEnum::class));
        $this->assertSame(NativeStringEnum::Draft, EnumNativeTypecast::toStringEnum('draft', NativeStringEnum::class));
        $this->assertSame(
            NativeStringEnum::Published,
            EnumNativeTypecast::toStringEnum(NativeStringEnum::Published, NativeStringEnum::class),
        );
    }

    public function testToStringEnumRejectsInvalidDatabaseValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EnumNativeTypecast::toStringEnum(1, NativeStringEnum::class);
    }

    public function testToStringEnumRequiresStringBackedEnum(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EnumNativeTypecast::toStringEnum(1, NativeIntegerEnum::class);
    }

    public function testToIntEnum(): void
    {
        $this->assertNull(EnumNativeTypecast::toIntEnum(null, NativeIntegerEnum::class));
        $this->assertSame(NativeIntegerEnum::Low, EnumNativeTypecast::toIntEnum(1, NativeIntegerEnum::class));
        $this->assertSame(NativeIntegerEnum::High, EnumNativeTypecast::toIntEnum('2', NativeIntegerEnum::class));
        $this->assertSame(
            NativeIntegerEnum::High,
            EnumNativeTypecast::toIntEnum(NativeIntegerEnum::High, NativeIntegerEnum::class),
        );
    }

    public function testToIntEnumRejectsInvalidDatabaseValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EnumNativeTypecast::toIntEnum('1.0', NativeIntegerEnum::class);
    }

    public function testToIntEnumRequiresIntBackedEnum(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EnumNativeTypecast::toIntEnum('draft', NativeStringEnum::class);
    }

    public function testNativeTypecastRequiresBackedEnum(): void
    {
        $this->expectException(InvalidArgumentException::class);

        EnumNativeTypecast::toStringEnum('value', NativeUnitEnum::class);
    }
}
