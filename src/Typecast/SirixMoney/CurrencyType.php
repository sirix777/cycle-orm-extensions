<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\SirixMoney;

use Brick\Money\Currency;
use Override;
use Sirix\Cycle\Extension\Exception\TypecastInvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Sirix\Money\Currency\CurrencyCatalog;
use Throwable;

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
            throw new TypecastInvalidArgumentException('Value must be an instance of Currency.');
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
            throw new TypecastInvalidArgumentException('Database value must be a string or numeric.');
        }

        try {
            return $this->currencyCatalog->get((int) $value);
        } catch (Throwable $exception) {
            throw TypecastInvalidArgumentException::wrap($exception);
        }
    }
}
