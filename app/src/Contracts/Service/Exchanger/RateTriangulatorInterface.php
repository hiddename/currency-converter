<?php

namespace App\Contracts\Service\Exchanger;

use App\Contracts\Model\CurrencyInterface;
use App\Contracts\Model\RateInterface;
use App\Exception\Model\Currency\BadCodeException;
use App\Exception\Model\Currency\EmptyCodeException;
use Doctrine\DBAL\Exception as DoctrineDBALException;
use Exception;

interface RateTriangulatorInterface
{
    /**
     * @param CurrencyInterface $baseCurrency
     * @param CurrencyInterface $quoteCurrency
     * @return array<RateInterface>
     * @throws EmptyCodeException
     * @throws BadCodeException
     * @throws DoctrineDBALException
     * @throws Exception
     */
    public function getRates(CurrencyInterface $baseCurrency, CurrencyInterface $quoteCurrency): array;
}
