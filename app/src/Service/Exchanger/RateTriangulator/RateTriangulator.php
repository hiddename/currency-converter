<?php

namespace App\Service\Exchanger\RateTriangulator;

use App\Contracts\Model\CurrencyInterface;
use App\Contracts\Service\Exchanger\RateTriangulatorInterface;
use App\Model\Currency\Currency;
use App\Model\Rate\Rate;
use Doctrine\ORM\EntityManagerInterface;

readonly class RateTriangulator implements RateTriangulatorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function getRates(CurrencyInterface $baseCurrency, CurrencyInterface $quoteCurrency): array
    {
        $statement = $this->entityManager->getConnection()->prepare(<<<SQL
            SELECT DISTINCT ON (dt, base_currency, quote_currency, factor) * FROM (
                SELECT dt, base_currency, quote_currency, factor FROM rates
            
                UNION
            
                SELECT p.dt, p.base_currency, p.quote_currency, p.factor
                FROM (
                    SELECT f.dt, f.base_currency, t.base_currency quote_currency, f.factor / t.factor factor
                    FROM rates f, rates t
                    WHERE f.quote_currency = t.quote_currency
                ) p
                LEFT OUTER JOIN rates r
                ON p.dt = r.dt
                AND p.base_currency = r.base_currency
                AND p.quote_currency = r.quote_currency
                WHERE r.base_currency IS NULL
            ) t
            WHERE (t.base_currency = :base_currency AND t.quote_currency = :quote_currency);
        SQL);

        $statement->bindValue('base_currency', $baseCurrency->getCode());
        $statement->bindValue('quote_currency', $quoteCurrency->getCode());

        $rates = $statement->executeQuery()->fetchAllAssociative();

        array_walk($rates, function (array &$rate) {
            $rate = new Rate(
                new \DateTimeImmutable($rate['dt']),
                new Currency($rate['base_currency']),
                new Currency($rate['quote_currency']),
                decimal($rate['factor']),
            );
        });

        return $rates;
    }
}
