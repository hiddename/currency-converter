<?php

namespace App\Command;

use App\Contracts\Service\RateRefresher\RateRefresherInterface;
use App\Enum\Service\RateProvider\RateProviderKey;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:rate:refresh',
    description: 'Refresh rate',
)]
class RateRefreshCommand extends Command
{
    public function __construct(
        private readonly RateRefresherInterface $rateRefresher,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('provider-key', null, InputOption::VALUE_OPTIONAL, "Provider's key");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $providerKey = $input->getOption('provider-key');

        $providerKey
            ? $this->rateRefresher->refresh([RateProviderKey::from($providerKey)])
            : $this->rateRefresher->refresh();

        return Command::SUCCESS;
    }
}
