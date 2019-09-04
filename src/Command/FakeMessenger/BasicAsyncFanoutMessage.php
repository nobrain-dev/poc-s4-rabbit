<?php

declare(strict_types=1);

namespace App\Command\FakeMessenger;

use App\Message\BarAsyncMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;

class BasicAsyncFanoutMessage extends Command
{
    protected static $defaultName = 'fake:message:basic-async';

    /** @var MessageBusInterface */
    private $messageBus;

    /**
     * BasicSyncMessage constructor.
     *
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct();
        $this->messageBus = $messageBus;
    }

    protected function configure()
    {
        $this
            ->setDescription('Dispatch a sync message')
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

        $this->messageBus->dispatch($message);
    }
}
