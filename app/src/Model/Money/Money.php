<?php

declare(strict_types=1);

namespace App\Model\Money;

use App\Contracts\Model\CurrencyInterface;
use App\Contracts\Model\MoneyInterface;
use App\Exception\Model\Money\DifferentCurrenciesException;
use Decimal\Decimal;

class Money implements MoneyInterface
{
    private CurrencyInterface $currency;
    private Decimal $amount;

    /**
     * @param CurrencyInterface $currency
     * @param Decimal $amount
     */
    public function __construct(CurrencyInterface $currency, Decimal $amount)
    {
        $this->setCurrency($currency);
        $this->setAmount($amount);
    }

    public function getCurrency(): CurrencyInterface
    {
        return $this->currency;
    }

    public function getAmount(): Decimal
    {
        return $this->amount;
    }

    /**
     * @throws DifferentCurrenciesException
     */
    public function add(MoneyInterface $m): static
    {
        if (!$this->currency->equals($m->getCurrency())) {
            throw new DifferentCurrenciesException();
        }

        $this->amount = $this->amount + $m->getAmount();

        return $this;
    }

    /**
     * @throws DifferentCurrenciesException
     */
    public function sub(MoneyInterface $m): static
    {
        if (!$this->currency->equals($m->getCurrency())) {
            throw new DifferentCurrenciesException();
        }

        $this->amount = $this->amount - $m->getAmount();

        return $this;
    }

    public function mul(Decimal $factor): static
    {
        $this->amount = $this->amount->mul($factor);

        return $this;
    }

    public function div(Decimal $factor): static
    {
        $this->amount = $this->amount->div($factor);

        return $this;
    }

    public function round(int $roundPlaces = self::DEFAULT_ROUND_PLACES): static
    {
        $this->amount = $this->amount->round($roundPlaces);

        return $this;
    }

    public function negate(): static
    {
        $this->amount = $this->amount->negate();

        return $this;
    }

    public function isZero(): bool
    {
        return $this->amount->isZero();
    }

    public function isNegative(): bool
    {
        return $this->amount->isNegative();
    }

    public function isPositive(): bool
    {
        return $this->amount->isPositive();
    }

    public function equals(MoneyInterface $m): bool
    {
        return $this->currency->equals($m->getCurrency())
            && $this->amount->equals($m->getAmount());
    }

    public function convert(CurrencyInterface $currency, Decimal $rate): static
    {
        $this->setCurrency($currency);
        $this->mul($rate);

        return $this;
    }

    public function __toString(): string
    {
        return $this->amount . ' ' . $this->currency;
    }

    private function setCurrency(CurrencyInterface $currency): void
    {
        $this->currency = $currency;
    }

    private function setAmount(Decimal $amount): void
    {
        $this->amount = $amount;
    }
}
