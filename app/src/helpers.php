<?php

if (!function_exists('decimal')) {
    function decimal(Decimal\Decimal|int|string $value, int $precision = Decimal\Decimal::DEFAULT_PRECISION): Decimal\Decimal
    {
        return new Decimal\Decimal($value, $precision);
    }
}
