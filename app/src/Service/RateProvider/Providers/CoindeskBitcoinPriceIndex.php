<?php

namespace App\Service\RateProvider\Providers;

use App\Enum\Service\RateProvider\RateProviderKey;
use App\Model\Currency\Currency;
use App\Model\Rate\Rate;
use App\Service\RateProvider\RateProvider;
use DateTimeImmutable;

class CoindeskBitcoinPriceIndex extends RateProvider
{
    public function rateProviderKey(): RateProviderKey
    {
        return RateProviderKey::COINDESK_BITCOIN_PRICE_INDEX;
    }

    protected function transform(array $data): array
    {
        return array_map(
            fn(array $rate): Rate => new Rate(
                new DateTimeImmutable($data['time']['updated']),
                $this->baseCurrency,
                new Currency($rate['code']),
                decimal(preg_replace('/,/', '', $rate['rate'])),
            ),
            $data['bpi'],
        );
    }
}
