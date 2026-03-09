<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Uuid;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Sirix\Cycle\Extension\Typecast\Uuid\UuidNativeTypecast;

final class UuidNativeTypecastTest extends TestCase
{
    public function testToUuid(): void
    {
        $uuid = Uuid::uuid7();
        $uuidString = $uuid->toString();
        $uuidBytes = $uuid->getBytes();

        $this->assertNull(UuidNativeTypecast::toUuid(null));
        $this->assertInstanceOf(UuidInterface::class, UuidNativeTypecast::toUuid($uuid));
        $this->assertSame($uuidString, UuidNativeTypecast::toUuid($uuidString)?->toString());
        $this->assertSame($uuidString, UuidNativeTypecast::toUuid($uuidBytes)?->toString());
    }

    public function testToUuidInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidNativeTypecast::toUuid(100);
    }

    public function testToUuidFromString(): void
    {
        $uuid = Uuid::uuid7();
        $result = UuidNativeTypecast::toUuidFromString($uuid->toString());

        $this->assertInstanceOf(UuidInterface::class, $result);
        $this->assertSame($uuid->toString(), $result->toString());
    }

    public function testToUuidFromStringInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidNativeTypecast::toUuidFromString(100);
    }

    public function testToUuidFromBytes(): void
    {
        $uuid = Uuid::uuid7();
        $result = UuidNativeTypecast::toUuidFromBytes($uuid->getBytes());

        $this->assertInstanceOf(UuidInterface::class, $result);
        $this->assertSame($uuid->toString(), $result->toString());
    }

    public function testToUuidFromBytesInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidNativeTypecast::toUuidFromBytes(100);
    }
}
