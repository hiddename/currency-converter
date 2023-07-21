<?php

namespace App\Exception\Model\Currency;

use App\Exception\AppException;

class BadCodeException extends AppException
{
    public function __construct(string $currencyCode)
    {
        $message = "Bad currency: $currencyCode";

        parent::__construct($message);
    }
}
