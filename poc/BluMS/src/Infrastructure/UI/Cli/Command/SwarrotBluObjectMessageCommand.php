<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\UI\Cli\Command;

use BluMS\Domain\Model\BluObject\Event\NewBluObjectCreated;
use BluMS\Infrastructure\Integration\Outcoming\BluIntegrationEventProducer;
use BluMS\Infrastructure\Integration\Outcoming\BluIntegrationEventPublisher;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SwarrotBluObjectMessageCommand extends Command
{
    protected static $defaultName = 'blums:object:swarrot-message';

    /** @var BluIntegrationEventPublisher */
    private $producer;

    public function __construct(BluIntegrationEventPublisher $producer)
    {
        parent::__construct();
        $this->producer = $producer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate BluObject event and dispach with Swarrot custom producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $message = NewBluObjectCreated::withData('001', 'blu_object_name', 'http://www.blu.com');

        $io->writeln('Generate BluObject event and dispach with custom producer');

        $io->writeln('');

        //$this->producer->publish(json_encode($message->__toArray()));
        $this->producer->publish($message);
    }
}
