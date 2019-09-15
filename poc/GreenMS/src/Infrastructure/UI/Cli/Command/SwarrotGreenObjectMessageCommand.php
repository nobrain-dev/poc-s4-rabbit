<?php

declare(strict_types=1);

namespace GreenMS\Infrastructure\UI\Cli\Command;


use GreenMS\Domain\Model\Event\NewGreenObjectCreated;
use GreenMS\Infrastructure\Integration\Outcoming\GreenIntegrationSwarrotEventPublisher;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SwarrotGreenObjectMessageCommand extends Command
{
    protected static $defaultName = 'greenms:object:swarrot-message';

    /** @var GreenIntegrationSwarrotEventPublisher */
    private $producer;

    public function __construct(GreenIntegrationSwarrotEventPublisher $producer)
    {
        parent::__construct();
        $this->producer = $producer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate GreenObject event and dispach with Swarrot custom producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $message = NewGreenObjectCreated::withData('001', 'green_object_name', 'http://www.green.com');

        $io->writeln('Generate GreenObject event and dispach with custom producer');

        $io->writeln('');

        //$this->producer->publish(json_encode($message->__toArray()));
        $this->producer->publish($message);
    }
}
