<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Uuid;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidToStringType;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;

final class UuidToStringTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new UuidToStringType();
        $uuid = Uuid::uuid4();
        $context = new UncastContext('uuid', []);

        $result = $type->convertToDatabaseValue($uuid, $context);

        $this->assertEquals($uuid->toString(), $result);
    }

    public function testConvertToDatabaseValueNull(): void
    {
        $type = new UuidToStringType();
        $context = new UncastContext('uuid', []);

        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new UuidToStringType();
        $context = new UncastContext('uuid', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-uuid', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new UuidToStringType();
        $uuid = Uuid::uuid4();
        $context = new CastContext('uuid', []);

        $result = $type->convertToPhpValue($uuid->toString(), $context);

        $this->assertTrue($uuid->equals($result));
    }

    public function testConvertToPhpValueNull(): void
    {
        $type = new UuidToStringType();
        $context = new CastContext('uuid', []);

        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new UuidToStringType();
        $context = new CastContext('uuid', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue('invalid-uuid-string', $context);
    }
}
