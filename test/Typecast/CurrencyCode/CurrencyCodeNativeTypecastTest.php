<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Test\Typecast\CurrencyCode;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sirix\Cycle\Extension\Typecast\CurrencyCode\CurrencyCodeNativeTypecast;
use Sirix\Money\FiatCurrencyCode;

final class CurrencyCodeNativeTypecastTest extends TestCase
{
    public function testToCurrencyCode(): void
    {
        $result = CurrencyCodeNativeTypecast::toCurrencyCode(978);

        $this->assertSame(FiatCurrencyCode::Eur, $result);
    }

    public function testToCurrencyCodeInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        CurrencyCodeNativeTypecast::toCurrencyCode([]);
    }
}
