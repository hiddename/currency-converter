<?php

namespace App\Contracts\Service\RateRefresher;

use App\Enum\Service\RateProvider\RateProviderKey;

interface RateRefresherInterface
{
    /**
     * @param array<RateProviderKey> $rateProviderKeys
     * @return void
     */
    public function refresh(array $rateProviderKeys = []): void;
}
