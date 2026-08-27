<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\SirixMoney;

use Brick\Money\Money;
use InvalidArgumentException;
use Override;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Cycle\Extension\Typecast\Context\UncastContext;
use Sirix\Cycle\Extension\Typecast\Contract\TypeInterface;
use Sirix\Money\MoneyFactory;
use Sirix\Money\MoneyFormatter;

use function is_numeric;
use function is_string;

abstract class AbstractMoneyType implements TypeInterface
{
    public function __construct(
        protected readonly MoneyFactory $moneyFactory,
        private readonly MoneyFormatter $moneyFormatter = new MoneyFormatter(),
    ) {}

    #[Override]
    public function convertToDatabaseValue(mixed $value, UncastContext $context): ?string
    {
        if (null === $value) {
            return null;
        }

        if (! $value instanceof Money) {
            throw new InvalidArgumentException('Value must be an instance of Money.');
        }

        return $this->toDatabaseValue($value);
    }

    #[Override]
    public function convertToPhpValue(mixed $value, CastContext $context): ?Money
    {
        if (null === $value) {
            return null;
        }

        if (! is_string($value) && ! is_numeric($value)) {
            throw new InvalidArgumentException('Database value must be a string or numeric.');
        }

        return $this->toPhpValue($value, $context);
    }

    final protected function amountToDatabaseValue(Money $value): string
    {
        return $this->moneyFormatter->amount($value);
    }

    final protected function minorAmountToDatabaseValue(Money $value): string
    {
        return $this->moneyFormatter->minorAmount($value);
    }

    abstract protected function toDatabaseValue(Money $value): string;

    abstract protected function toPhpValue(mixed $value, CastContext $context): Money;
}
