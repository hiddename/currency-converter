<?php

namespace App\Exception\Model\Money;

use App\Exception\AppException;

class DifferentCurrenciesException extends AppException
{
    public function __construct()
    {
        parent::__construct('Illegal operation due to different currencies of money.');
    }
}
