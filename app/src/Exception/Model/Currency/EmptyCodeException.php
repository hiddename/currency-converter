<?php

namespace App\Exception\Model\Currency;

use App\Exception\AppException;

class EmptyCodeException extends AppException
{
    public function __construct()
    {
        parent::__construct('Currency can not be empty');
    }
}
