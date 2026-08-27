<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\SirixMoney;

use Brick\Money\Money;
use InvalidArgumentException;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Money\MoneyFactory;
use Sirix\Money\MoneyFormatter;

use function array_key_exists;
use function is_int;
use function is_string;

final class MoneyMinorCurrencyCodeColumnType extends AbstractMoneyType
{
    public function __construct(
        MoneyFactory $moneyFactory,
        private readonly string $currencyCodeEntityProperty = 'currencyCode',
        MoneyFormatter $moneyFormatter = new MoneyFormatter(),
    ) {
        parent::__construct($moneyFactory, $moneyFormatter);
    }

    protected function toDatabaseValue(Money $value): string
    {
        return $this->minorAmountToDatabaseValue($value);
    }

    protected function toPhpValue(mixed $value, CastContext $context): Money
    {
        $currencyCode = $this->currencyCode($context);

        return $this->moneyFactory->ofMinor($value, $currencyCode);
    }

    private function currencyCode(CastContext $context): int|string
    {
        if (! array_key_exists($this->currencyCodeEntityProperty, $context->data)) {
            throw new InvalidArgumentException("Entity property [{$this->currencyCodeEntityProperty}] not found in context.");
        }

        $currencyCode = $context->data[$this->currencyCodeEntityProperty];
        if (! is_int($currencyCode) && ! is_string($currencyCode)) {
            throw new InvalidArgumentException("Entity property [{$this->currencyCodeEntityProperty}] must be an integer or string.");
        }

        return $currencyCode;
    }
}
