<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateTimeStringType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class ChronosToDateTimeStringTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new ChronosToDateTimeStringType();
        $chronos = Chronos::now();
        $context = new UncastContext('updated_at', []);

        $result = $type->convertToDatabaseValue($chronos, $context);

        $this->assertEquals($chronos->toDateTimeString(), $result);
    }

    public function testConvertToDatabaseValueNull(): void
    {
        $type = new ChronosToDateTimeStringType();
        $context = new UncastContext('updated_at', []);

        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new ChronosToDateTimeStringType();
        $context = new UncastContext('updated_at', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-chronos-object', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new ChronosToDateTimeStringType();
        $dateTimeString = '2023-01-01 12:00:00';
        $context = new CastContext('updated_at', []);

        $result = $type->convertToPhpValue($dateTimeString, $context);

        $this->assertInstanceOf(Chronos::class, $result);
        $this->assertEquals($dateTimeString, $result->toDateTimeString());
    }

    public function testConvertToPhpValueNull(): void
    {
        $type = new ChronosToDateTimeStringType();
        $context = new CastContext('updated_at', []);

        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new ChronosToDateTimeStringType();
        $context = new CastContext('updated_at', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(['invalid' => 'type'], $context);
    }
}
