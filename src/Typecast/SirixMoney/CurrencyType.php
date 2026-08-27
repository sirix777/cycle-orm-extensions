<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\SirixMoney;

use Brick\Money\Currency;
use InvalidArgumentException;
use Override;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Sirix\Money\Currency\CurrencyCatalog;

use function is_numeric;
use function is_string;

final readonly class CurrencyType implements TypeInterface
{
    public function __construct(private CurrencyCatalog $currencyCatalog) {}

    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?int
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof Currency) {
            throw new InvalidArgumentException('Value must be an instance of Currency.');
        }

        return $value->getNumericCode();
    }

    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): ?Currency
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return $this->currencyCatalog->get((int) $value);
    }
}
