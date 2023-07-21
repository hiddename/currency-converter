<?php

declare(strict_types=1);

namespace App\Model\Rate;

use App\Contracts\Model\CurrencyInterface;
use App\Contracts\Model\RateInterface;
use DateTimeImmutable;
use Decimal\Decimal;

readonly class Rate implements RateInterface
{
    public function __construct(
        private DateTimeImmutable $dt,
        private CurrencyInterface $base,
        private CurrencyInterface $quote,
        private Decimal $factor,
    )
    {
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->dt;
    }

    public function getBase(): CurrencyInterface
    {
        return $this->base;
    }

    public function getQuote(): CurrencyInterface
    {
        return $this->quote;
    }

    public function getFactor(): Decimal
    {
        return $this->factor;
    }

    public function __toString(): string
    {
        return "1 $this->base = $this->factor $this->quote (" . $this->dt->format('Y-m-d H:i:s') . ')';
    }
}
