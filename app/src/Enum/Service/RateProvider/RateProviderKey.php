<?php

namespace App\Enum\Service\RateProvider;

use App\Enum\EnumToArray;

enum RateProviderKey: string
{
    use EnumToArray;

    case EUROPEAN_CENTRAL_BANK = 'ecb';
    case COINDESK_BITCOIN_PRICE_INDEX = 'coindesk_bitcoin_price_index';
}
