<?php

namespace App\Model\Currency;

use App\Contracts\Model\CurrencyInterface;
use App\Exception\Model\Currency\BadCodeException;
use App\Exception\Model\Currency\EmptyCodeException;

readonly class Currency implements CurrencyInterface
{
    private const CODE_REGEXP = '/^[A-Za-z]+$/';

    private string $code;

    /**
     * @throws EmptyCodeException
     * @throws BadCodeException
     */
    public function __construct(string $code)
    {
        $this->setCode($code);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function equals(CurrencyInterface $c): bool
    {
        return $this->code === $c->getCode();
    }

    public function __toString(): string
    {
        return $this->code;
    }

    /**
     * @throws EmptyCodeException
     * @throws BadCodeException
     */
    private function setCode(string $code): void
    {
        if ($code === '') {
            throw new EmptyCodeException();
        }

        $original = $code;
        $code = strtoupper($code);

        if (preg_match(static::CODE_REGEXP, $code) === false) {
            throw new BadCodeException($original);
        }

        $this->code = $code;
    }
}
