<?php

namespace App\Contracts\Model;

use App\Contracts\Stringable;
use Decimal\Decimal;

interface RateInterface extends Stringable
{
    public function getDateTime(): \DateTimeImmutable;
    public function getBase(): CurrencyInterface;
    public function getQuote(): CurrencyInterface;
    public function getFactor(): Decimal;
}
