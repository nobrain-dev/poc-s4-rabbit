<?php

declare(strict_types=1);

namespace GreenMS\Infrastructure\UI\Cli\Command;

use GreenMS\Domain\Model\Event\NewGreenObjectCreated;
use GreenMS\Infrastructure\Integration\Outcoming\GreenIntegrationEventProducer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GreenObjectMessageCommand extends Command
{
    protected static $defaultName = 'greenms:object:message';

    /** @var ProducerInterface */
    private $producer;

    public function __construct(GreenIntegrationEventProducer $producer)
    {
        parent::__construct();
        $this->producer = $producer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate GreenObject event and dispach with custom producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $message = NewGreenObjectCreated::withData('001', 'green_object_name', 'http://www.green.com');

        $io->writeln('Generate GreenObject event and dispach with custom producer');

        $io->writeln('');

        //$this->producer->publish(json_encode($message->__toArray()));
        $this->producer->add($message);
    }
}
