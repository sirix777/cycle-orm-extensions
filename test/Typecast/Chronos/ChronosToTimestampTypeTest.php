<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToTimestampType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class ChronosToTimestampTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new ChronosToTimestampType();
        $chronos = Chronos::now();
        $context = new UncastContext('created_at', []);

        $result = $type->convertToDatabaseValue($chronos, $context);

        $this->assertEquals((string) $chronos->getTimestamp(), $result);
    }

    public function testConvertToDatabaseValueNull(): void
    {
        $type = new ChronosToTimestampType();
        $context = new UncastContext('created_at', []);

        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new ChronosToTimestampType();
        $context = new UncastContext('created_at', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-chronos-object', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new ChronosToTimestampType();
        $timestamp = time();
        $context = new CastContext('created_at', []);

        $result = $type->convertToPhpValue($timestamp, $context);

        $this->assertInstanceOf(Chronos::class, $result);
        $this->assertEquals($timestamp, $result->getTimestamp());
    }

    public function testConvertToPhpValueString(): void
    {
        $type = new ChronosToTimestampType();
        $timestamp = (string) time();
        $context = new CastContext('created_at', []);

        $result = $type->convertToPhpValue($timestamp, $context);

        $this->assertInstanceOf(Chronos::class, $result);
        $this->assertEquals((int) $timestamp, $result->getTimestamp());
    }

    public function testConvertToPhpValueNull(): void
    {
        $type = new ChronosToTimestampType();
        $context = new CastContext('created_at', []);

        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new ChronosToTimestampType();
        $context = new CastContext('created_at', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(['invalid' => 'type'], $context);
    }
}
