<?php

namespace App\Command;

use App\Contracts\Service\Exchanger\ExchangerInterface;
use App\Exception\Model\Currency\BadCodeException;
use App\Exception\Model\Currency\EmptyCodeException;
use App\Exception\Service\Exchanger\ImpossibleExchangeException;
use App\Model\Currency\Currency;
use App\Model\Money\Money;
use Decimal\Decimal;
use Doctrine\DBAL\Exception as DoctrineDBALException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:exchange',
    description: 'Exchange <amount> of <base> to <quote>',
)]
class ExchangeCommand extends Command
{
    public function __construct(
        private readonly ExchangerInterface $exchanger,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount')
            ->addArgument('base', InputArgument::REQUIRED, 'Base currency')
            ->addArgument('quote', InputArgument::REQUIRED, 'Quote (counter) currency')
        ;
    }

    /**
     * @throws BadCodeException
     * @throws EmptyCodeException
     * @throws DoctrineDBALException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $base = new Money(
            new Currency($this->getBaseArgument($input)),
            $this->getAmountArgument($input),
        );

        try {
            $quotes = $this->exchanger->exchange(
                $base,
                new Currency($this->getQuoteArgument($input)),
            );
        } catch (ImpossibleExchangeException $e) {
            $io->warning($e->getMessage());

            return Command::INVALID;
        }

        foreach ($quotes as $quote) {
            $io->writeln(
                sprintf(
                    '%s = %s',
                    $base->round()->__toString(),
                    $quote->round()->__toString(),
                ),
            );
        }

        return Command::SUCCESS;
    }

    private function getAmountArgument(InputInterface $input): Decimal
    {
        $amount = $input->getArgument('amount');

        return decimal($amount);
    }

    private function getBaseArgument(InputInterface $input): string
    {
        return $input->getArgument('base');
    }

    private function getQuoteArgument(InputInterface $input): string
    {
        return $input->getArgument('quote');
    }
}
