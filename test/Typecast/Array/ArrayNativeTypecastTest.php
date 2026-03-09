<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Array;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Array\ArrayNativeTypecast;

final class ArrayNativeTypecastTest extends TestCase
{
    public function testToArrayFromDelimitedString(): void
    {
        $this->assertSame([], ArrayNativeTypecast::toArrayFromDelimitedString(null));
        $this->assertSame([], ArrayNativeTypecast::toArrayFromDelimitedString(''));
        $this->assertSame(['a', 'b'], ArrayNativeTypecast::toArrayFromDelimitedString('a,b'));
        $this->assertSame(['a', 'b'], ArrayNativeTypecast::toArrayFromDelimitedString('a|b', '|'));
    }

    public function testToArrayFromDelimitedStringInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ArrayNativeTypecast::toArrayFromDelimitedString(123);
    }

    public function testToEnumArrayFromDelimitedString(): void
    {
        $result = ArrayNativeTypecast::toEnumArrayFromDelimitedString('1,2', NativeArrayIntEnum::class);

        $this->assertSame([NativeArrayIntEnum::One, NativeArrayIntEnum::Two], $result);
    }

    public function testToArrayFromJson(): void
    {
        $this->assertSame(['a' => 1], ArrayNativeTypecast::toArrayFromJson('{"a":1}'));
    }

    public function testToArrayFromJsonInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ArrayNativeTypecast::toArrayFromJson('invalid-json');
    }
}

enum NativeArrayIntEnum: int
{
    case One = 1;
    case Two = 2;
}
