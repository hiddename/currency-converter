<?php

namespace App\Contracts\Service\Exchanger;

use App\Contracts\Model\CurrencyInterface;
use App\Contracts\Model\MoneyInterface;
use App\Exception\Model\Currency\BadCodeException;
use App\Exception\Model\Currency\EmptyCodeException;
use App\Exception\Service\Exchanger\ImpossibleExchangeException;
use Doctrine\DBAL\Exception as DoctrineDBALException;

interface ExchangerInterface
{
    /**
     * @param MoneyInterface $m
     * @param CurrencyInterface $currency
     * @return array<MoneyInterface>
     * @throws BadCodeException
     * @throws EmptyCodeException
     * @throws DoctrineDBALException
     * @throws ImpossibleExchangeException
     */
    public function exchange(MoneyInterface $m, CurrencyInterface $currency): array;
}
