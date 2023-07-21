<?php

namespace App\Contracts\Model;

use App\Contracts\Stringable;

interface CurrencyInterface extends Stringable
{
    public function getCode(): string;
    public function equals(CurrencyInterface $c): bool;
}
