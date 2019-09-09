<?php

declare(strict_types=1);

namespace GreenMS\Infrastructure\UI\Cli\Command;

use GreenMS\Infrastructure\Integration\Outcoming\OutcomingEventProducer;
use GreenMS\Domain\Model\Event\NewGreenObjectCreated;
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
            ->setDescription('Generate GreenObject event and dispach with custom producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $message = NewGreenObjectCreated::withData('001', 'my_name', 'http://www.xxxxx.com');

        $io->writeln('Generate BluObject event and dispach with custom producer');

        $io->writeln('');

        //$this->producer->publish(json_encode($message->__toArray()));
        $this->producer->add($message);
    }
}
