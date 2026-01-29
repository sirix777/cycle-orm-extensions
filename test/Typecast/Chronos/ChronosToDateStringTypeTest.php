<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Chronos;

use Cake\Chronos\Chronos;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosToDateStringType;
use Vjik\CycleTypecast\CastContext;
use Vjik\CycleTypecast\UncastContext;

final class ChronosToDateStringTypeTest extends TestCase
{
    public function testConvertToDatabaseValue(): void
    {
        $type = new ChronosToDateStringType();
        $date = Chronos::parse('2023-01-01 12:00:00');
        $context = new UncastContext('field', []);

        $this->assertEquals('2023-01-01', $type->convertToDatabaseValue($date, $context));
        $this->assertNull($type->convertToDatabaseValue(null, $context));
    }

    public function testConvertToDatabaseValueInvalid(): void
    {
        $type = new ChronosToDateStringType();
        $context = new UncastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToDatabaseValue('not-a-chronos', $context);
    }

    public function testConvertToPhpValue(): void
    {
        $type = new ChronosToDateStringType();
        $context = new CastContext('field', []);

        $result = $type->convertToPhpValue('2023-01-01', $context);
        $this->assertInstanceOf(Chronos::class, $result);
        $this->assertEquals('2023-01-01', $result->toDateString());
        $this->assertEquals('00:00:00', $result->format('H:i:s'));
        
        $this->assertNull($type->convertToPhpValue(null, $context));
    }

    public function testConvertToPhpValueInvalid(): void
    {
        $type = new ChronosToDateStringType();
        $context = new CastContext('field', []);

        $this->expectException(InvalidArgumentException::class);
        $type->convertToPhpValue(123, $context);
    }
}
