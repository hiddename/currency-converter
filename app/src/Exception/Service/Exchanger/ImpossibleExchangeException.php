<?php

namespace App\Exception\Service\Exchanger;

use App\Exception\AppException;
use App\Model\Currency\Currency;

class ImpossibleExchangeException extends AppException
{
    public function __construct(Currency $base, Currency $quote)
    {
        parent::__construct("Impossible to exchange such pair ($base - $quote)");
    }
}
