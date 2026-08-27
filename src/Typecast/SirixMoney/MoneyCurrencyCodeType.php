<?php

declare(strict_types=1);

namespace Sirix\Cycle\Extension\Typecast\SirixMoney;

use Brick\Money\Money;
use Sirix\Cycle\Extension\Typecast\Context\CastContext;
use Sirix\Money\MoneyFactory;
use Sirix\Money\MoneyFormatter;

final class MoneyCurrencyCodeType extends AbstractMoneyType
{
    public function __construct(
        MoneyFactory $moneyFactory,
        private readonly int|string $currencyCode,
        MoneyFormatter $moneyFormatter = new MoneyFormatter(),
    ) {
        parent::__construct($moneyFactory, $moneyFormatter);
    }

    protected function toDatabaseValue(Money $value): string
    {
        return $this->amountToDatabaseValue($value);
    }

    protected function toPhpValue(mixed $value, CastContext $context): Money
    {
        return $this->moneyFactory->of($value, $this->currencyCode);
    }
}
