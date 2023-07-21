<?php

namespace App\Service\RateProvider;

use App\Contracts\Model\RateInterface;
use App\Contracts\Service\RateProvider\RateProviderInterface;
use App\Contracts\Service\RateProvider\ResponseParserInterface;
use App\Exception\Model\Currency as CurrencyExceptions;
use App\Model\Currency\Currency;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class RateProvider implements RateProviderInterface
{
    /**
     * @param array $data
     * @return array<RateInterface>
     * @throws CurrencyExceptions\BadCodeException
     * @throws CurrencyExceptions\EmptyCodeException
     * @throws Exception
     */
    abstract protected function transform(array $data): array;

    protected readonly Currency $baseCurrency;

    /**
     * @throws CurrencyExceptions\EmptyCodeException
     * @throws CurrencyExceptions\BadCodeException
     */
    public function __construct(
        private readonly HttpClientInterface $http,
        private readonly ResponseParserInterface $parser,
        private readonly string $url,
        string $baseCurrencyCode,
    )
    {
        $this->baseCurrency = new Currency($baseCurrencyCode);
    }

    public function getRates(): array
    {
        return $this->transform(
            $this->parse($this->fetch()),
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function fetch(): ResponseInterface
    {
        return $this->http->request('GET', $this->url);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function parse(ResponseInterface $response): array
    {
        return $this->parser->parse($response);
    }
}
