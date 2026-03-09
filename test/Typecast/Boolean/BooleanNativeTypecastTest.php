<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Boolean;

use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Boolean\BooleanNativeTypecast;

final class BooleanNativeTypecastTest extends TestCase
{
    public function testToBool(): void
    {
        $this->assertTrue(BooleanNativeTypecast::toBool(1));
        $this->assertTrue(BooleanNativeTypecast::toBool('1'));
        $this->assertFalse(BooleanNativeTypecast::toBool(0));
        $this->assertFalse(BooleanNativeTypecast::toBool(null));
    }
}
