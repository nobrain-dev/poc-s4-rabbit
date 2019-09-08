<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\UI\Cli\Command;

use BluMS\Domain\Model\BluObject\Event\BluObjectWasCreated;
use BluMS\Infrastructure\Integration\Outcoming\OutcomingEventProducer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BluObjectMessageCommand extends Command
{
    protected static $defaultName = 'blums:object:message';

    /** @var ProducerInterface */
    private $producer;

    /**
     * OrderGeneratorCommand constructor.
     */
    //public function __construct(ProducerInterface $producer)
    public function __construct(OutcomingEventProducer $producer)
    {
        parent::__construct();
        $this->producer = $producer;
        //$this->producer->setContentType('application/json');
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate BluObject event and dispach with custom producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $messageData = [
            'alpha' => 'alpha',
            'beta' => 'beta',
        ];

        $message = new BluObjectWasCreated('1', 'pippo');

        $io->writeln('Generate BluObject event and dispach with custom producer');
        //$io->writeln('Message Data : '.json_encode($messageData));
        $io->writeln('');

        //$this->producer->publish(json_encode($message->__toArray()));
        $this->producer->add($message);
    }
}
