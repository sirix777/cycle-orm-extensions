<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\Chronos;

use Cake\Chronos\Chronos;
use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\Chronos\ChronosNativeTypecast;

final class ChronosNativeTypecastTest extends TestCase
{
    public function testToChronos(): void
    {
        $chronos = new Chronos('2026-03-09 10:00:00');
        $immutable = new DateTimeImmutable('2026-03-09 10:00:00');

        $this->assertNull(ChronosNativeTypecast::toChronos(null));
        $this->assertInstanceOf(Chronos::class, ChronosNativeTypecast::toChronos($chronos));
        $this->assertInstanceOf(Chronos::class, ChronosNativeTypecast::toChronos($immutable));
        $this->assertInstanceOf(Chronos::class, ChronosNativeTypecast::toChronos('2026-03-09 10:00:00'));
    }

    public function testToChronosInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ChronosNativeTypecast::toChronos(123);
    }

    public function testToChronosFromTimestamp(): void
    {
        $result = ChronosNativeTypecast::toChronosFromTimestamp(1710000000);
        $this->assertInstanceOf(Chronos::class, $result);

        $resultFromString = ChronosNativeTypecast::toChronosFromTimestamp('1710000000');
        $this->assertInstanceOf(Chronos::class, $resultFromString);
        $this->assertSame($result->getTimestamp(), $resultFromString->getTimestamp());
    }

    public function testToChronosFromTimestampInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ChronosNativeTypecast::toChronosFromTimestamp('not-a-timestamp');
    }
}
