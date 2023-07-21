<?php

namespace App\Service\Exchanger;

use App\Contracts\Model\CurrencyInterface;
use App\Contracts\Model\MoneyInterface;
use App\Contracts\Service\Exchanger\ExchangerInterface;
use App\Contracts\Service\Exchanger\RateTriangulatorInterface;
use App\Exception\Service\Exchanger\ImpossibleExchangeException;

readonly class Exchanger implements ExchangerInterface
{
    public function __construct(
        private RateTriangulatorInterface $rateTriangulator,
    )
    {
    }

    public function exchange(MoneyInterface $m, CurrencyInterface $currency): array
    {
        $rates = $this->rateTriangulator->getRates($m->getCurrency(), $currency);

        if (!$rates) {
            throw new ImpossibleExchangeException($m->getCurrency(), $currency);
        }

        $result = [];

        foreach ($rates as $rate) {
            $ri = clone $m;
            $ri->convert($currency, $rate->getFactor());

            $result[] = $ri;
        }

        return $result;
    }
}
