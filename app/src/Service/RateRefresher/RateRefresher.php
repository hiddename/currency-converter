<?php

namespace App\Service\RateRefresher;

use App\Contracts\Model\RateInterface;
use App\Contracts\Service\RateProvider\RateProviderInterface;
use App\Contracts\Service\RateRefresher\RateRefresherInterface;
use App\Enum\Service\RateProvider\RateProviderKey;
use App\Exception\AppException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use Throwable;

readonly class RateRefresher implements RateRefresherInterface
{
    /**
     * @param iterable<RateProviderInterface> $providers
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private iterable $providers,
        private EntityManagerInterface $entityManager,
    )
    {
        foreach ($providers as $provider) {
            if (!$provider instanceof RateProviderInterface) {
                throw new InvalidArgumentException(
                    sprintf('You can only pass instance of %s as provider. Got: %s.', RateProviderInterface::class, $provider::class),
                );
            }
        }
    }

    /**
     * @param array<RateProviderKey> $rateProviderKeys
     * @throws AppException
     */
    public function refresh(array $rateProviderKeys = []): void
    {
        $rpkValues = array_column($rateProviderKeys, 'value');
        try {
            foreach ($this->providers as $provider) {
                if (!$rpkValues || in_array($provider->rateProviderKey()->value, $rpkValues)) {
                    $this->persist($provider->getRates());
                }
            }
        } catch (Throwable $e) {
            throw new AppException('An error occurred while rates refreshing!', 0, $e);
        }
    }

    /**
     * @throws Exception
     */
    private function persist(array $rates): void
    {
        $values = array_map(fn(RateInterface $r): string => sprintf('(%s),(%s)',
            join(',', [
                '\'' . $r->getDateTime()->format('Y-m-d H:i:s') . '\'',
                '\'' . $r->getBase()->getCode() . '\'',
                '\'' . $r->getQuote()->getCode() . '\'',
                '\'' . $r->getFactor()->toString() . '\'',
            ]),
            join(',', [
                '\'' . $r->getDateTime()->format('Y-m-d H:i:s') . '\'',
                '\'' . $r->getQuote()->getCode() . '\'',
                '\'' . $r->getBase()->getCode() . '\'',
                '\'' . decimal(1)->div($r->getFactor())->toString() . '\'',
            ]),
        ), $rates);
        $values = join(',', $values);

        $this->entityManager->getConnection()->executeQuery(<<<SQL
            INSERT INTO rates (dt, base_currency, quote_currency, factor)
            VALUES $values
            ON CONFLICT ON CONSTRAINT rates_bc_qc_key
            DO UPDATE SET
                dt = excluded.dt,
                factor = excluded.factor;
        SQL);
    }
}
