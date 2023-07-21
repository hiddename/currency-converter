<?php

namespace App\Contracts\Service\RateProvider;

use App\Enum\Service\RateProvider\RateProviderKey;
use App\Exception\Model\Currency\BadCodeException;
use App\Exception\Model\Currency\EmptyCodeException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

interface RateProviderInterface
{
    public function rateProviderKey(): RateProviderKey;

    /**
     * @throws RedirectionExceptionInterface
     * @throws EmptyCodeException
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws BadCodeException
     * @throws ServerExceptionInterface
     */
    public function getRates(): array;
}
