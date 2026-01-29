<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Uuid;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToBytesType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class UuidToBytesTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new UuidToBytesType();
        $uuid = Uuid::uuid4();
        $context = new UncastContext('uuid', []);

        $result = $type->convertToDatabaseValue($uuid, $context);

        $this->assertEquals($uuid->getBytes(), $result);
    }

    public function testConvertToDatabaseValueNull(): void
    {
        $type = new UuidToBytesType();
        $context = new UncastContext('uuid', []);

        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new UuidToBytesType();
        $context = new UncastContext('uuid', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-uuid', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new UuidToBytesType();
        $uuid = Uuid::uuid4();
        $context = new CastContext('uuid', []);

        $result = $type->convertToPhpValue($uuid->getBytes(), $context);

        $this->assertTrue($uuid->equals($result));
    }

    public function testConvertToPhpValueNull(): void
    {
        $type = new UuidToBytesType();
        $context = new CastContext('uuid', []);

        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new UuidToBytesType();
        $context = new CastContext('uuid', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('invalid-bytes', $context);
    }
}
