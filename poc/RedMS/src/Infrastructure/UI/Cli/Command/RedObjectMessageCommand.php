<?php

declare(strict_types=1);

namespace RedMS\Infrastructure\UI\Cli\Command;

use RedMS\Domain\Model\Event\NewRedObjectCreated;
use RedMS\Infrastructure\Integration\Outcoming\RedIntegrationEventProducer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RedObjectMessageCommand extends Command
{
    protected static $defaultName = 'redms:object:message';

    /** @var ProducerInterface */
    private $producer;

    public function __construct(RedIntegrationEventProducer $producer)
    {
        parent::__construct();
        $this->producer = $producer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate RedObject event and dispach with custom producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $message = NewRedObjectCreated::withData('001', 'red_object_name', 'http://www.red.com');

        $io->writeln('Generate RedObject event and dispach with custom producer');

        $io->writeln('');

        //$this->producer->publish(json_encode($message->__toArray()));
        $this->producer->add($message);
    }
}
