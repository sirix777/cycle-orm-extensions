<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Boolean;

use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Boolean\BooleanToIntType;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

final class BooleanToIntTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new BooleanToIntType();
        $context = new UncastContext('field', []);

        $this->assertSame(1, $type->convertToDatabaseValue(true, $context));
        $this->assertSame(0, $type->convertToDatabaseValue(false, $context));
    }

    public function testConvertToPhpValue(): void
    {
        $type = new BooleanToIntType();
        $context = new CastContext('field', []);

        $this->assertTrue($type->convertToPhpValue(1, $context));
        $this->assertTrue($type->convertToPhpValue('1', $context));
        $this->assertFalse($type->convertToPhpValue(0, $context));
        $this->assertFalse($type->convertToPhpValue(null, $context));
    }
}
