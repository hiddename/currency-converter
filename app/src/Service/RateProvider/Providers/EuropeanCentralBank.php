<?php

namespace App\Service\RateProvider\Providers;

use App\Enum\Service\RateProvider\RateProviderKey;
use App\Model\Currency\Currency;
use App\Model\Rate\Rate;
use App\Service\RateProvider\RateProvider;
use DateTimeImmutable;

class EuropeanCentralBank extends RateProvider
{
    public function rateProviderKey(): RateProviderKey
    {
        return RateProviderKey::EUROPEAN_CENTRAL_BANK;
    }

    protected function transform(array $data): array
    {
        $date = $data['Cube']['Cube']['@time'];

        return array_map(
            fn(array $rate): Rate => new Rate(
                new DateTimeImmutable($date),
                $this->baseCurrency,
                new Currency($rate['@currency']),
                decimal((string) $rate['@rate']),
            ),
            $data['Cube']['Cube']['Cube'],
        );
    }
}
