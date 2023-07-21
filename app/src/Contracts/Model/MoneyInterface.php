<?php

namespace App\Contracts\Model;

use App\Contracts\Stringable;
use Decimal\Decimal;

interface MoneyInterface extends Stringable
{
    public const DEFAULT_ROUND_PLACES = 8;

    public function getCurrency(): CurrencyInterface;
    public function getAmount(): Decimal;

    public function add(MoneyInterface $m): static;
    public function sub(MoneyInterface $m): static;
    public function mul(Decimal $factor): static;
    public function div(Decimal $factor): static;

    public function round(int $roundPlaces = self::DEFAULT_ROUND_PLACES): static;
    public function negate(): static;

    public function isZero(): bool;
    public function isNegative(): bool;
    public function isPositive(): bool;
    public function equals(MoneyInterface $m): bool;
    public function convert(CurrencyInterface $currency, Decimal $rate): static;
}
