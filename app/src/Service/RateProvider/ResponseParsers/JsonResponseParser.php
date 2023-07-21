<?php

namespace App\Service\RateProvider\ResponseParsers;

use App\Contracts\Service\RateProvider\ResponseParserInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class JsonResponseParser implements ResponseParserInterface
{
    public function parse(ResponseInterface $response): array
    {
        return $response->toArray();
    }
}
