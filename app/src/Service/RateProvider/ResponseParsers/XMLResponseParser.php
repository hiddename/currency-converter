<?php

namespace App\Service\RateProvider\ResponseParsers;

use App\Contracts\Service\RateProvider\ResponseParserInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class XMLResponseParser implements ResponseParserInterface
{
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([], [
            new XmlEncoder(),
        ]);
    }

    public function parse(ResponseInterface $response): array
    {
        return $this->serializer->decode(
            $response->getContent(),
            'xml',
        );
    }
}
