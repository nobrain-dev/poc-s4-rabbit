<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\UI\Cli\Command;

use App\Message\BarAsyncMessage;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class OrderGeneratorCommand extends Command
{
    protected static $defaultName = 'blums:order:generate';

    /** @var ProducerInterface */
    private $producer;

    /**
     * OrderGeneratorCommand constructor.
     *
     * @param ProducerInterface $producer
     */
    public function __construct(ProducerInterface $producer)
    {
        parent::__construct();
        $this->producer = $producer;
        $this->producer->setContentType('application/json');
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate new order and dispach with producer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $messageData = [
            'alpha' => 'alpha',
            'beta' => 'beta',
        ];

        $message = new BarAsyncMessage('alpha', 'beta');

        $io->writeln('Message Data : '.json_encode($messageData));
        $io->writeln('');

        $this->producer->publish(json_encode($messageData));
    }
}
