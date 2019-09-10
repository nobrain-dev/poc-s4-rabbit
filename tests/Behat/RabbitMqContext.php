<?php

declare(strict_types=1);

namespace App\Tests\Behat;

//use AMQPChannel;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use LogicException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class RabbitMqContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param string $producerName
     *
     * @When /^the queue associated to "([^"]*)" producer is empty$/
     */
    public function theQueueAssociatedToProducerIsEmpty($producerName)
    {
        $queueName = $this->getQueueName($producerName);

        $channel = $this->getChannel($producerName);
        $channel->queue_declare($queueName, false, true, false, false);
        $channel->queue_purge($queueName);

        if ($channel->basic_get($queueName)) {
            throw new LogicException(sprintf('The queue %s does not seem to be empty.', $queueName));
        }
    }

    /**
     * @param string    $producerName
     * @param TableNode $tableNode
     *
     * @When /^the queue associated to "([^"]*)" producer has messages below:$/
     */
    public function theQueueAssociatedToProducerHasMessagesBelow($producerName, TableNode $tableNode)
    {
        $expectedMessages = $this->getExpectedMessages($tableNode);
        $queuedMessages = $this->getQueuedMessages($producerName);

        if ($expectedMessages != $queuedMessages) {
            throw new LogicException(sprintf(
                'Message mismatch. Queue contains:%s%s',
                PHP_EOL,
                json_encode($queuedMessages)
            ));
        }
    }

    /**
     * @param TableNode $tableNode
     *
     * @return array
     */
    private function getExpectedMessages(TableNode $tableNode)
    {
        $expectedMessages = [];
        foreach ($tableNode->getRowsHash() as $message) {
            $expectedMessages[] = $this->replaceDynamicValues($message);
        }

        return $expectedMessages;
    }

    /**
     * @param string $producerName
     *
     * @return array
     */
    private function getQueuedMessages($producerName)
    {
        $channel = $this->getChannel($producerName); //var_dump($channel);

        $queuedMessages = [];
        do {
            /** @var AMQPMessage $message */
            //$message = $channel->basic_get($this->getQueueName($producerName)); //var_dump($this->getQueueName($producerName)); //var_dump($message);
            $message = $channel->basic_get('blu_incomin_event_qu');
            if (!$message instanceof AMQPMessage) {
                break;
            }

            $queuedMessages[] = $this->replaceDynamicValues($message->getBody());

            if (0 == $message->get('message_count')) {
                break;
            }
        } while (true);

        return $queuedMessages;
    }

    /**
     * @param string $producerName
     *
     * @return AMQPChannel
     */
    private function getChannel($producerName)
    {
        $container = $this->kernel->getContainer();

        $producerService = sprintf('old_sound_rabbit_mq.%s_producer', $producerName);
        $producer = $container->get($producerService);

        return $producer->getChannel();
    }

    /**
     * @param string $producerName
     *
     * @return string
     */
    private function getQueueName($producerName)
    {
        //return sprintf('%s_queue', $producerName);
        //var_dump(sprintf('%s_qu', $producerName));
        return sprintf('%s_qu', $producerName);
    }

    /**
     * @param string $data
     *
     * @return string
     */
    private function replaceDynamicValues($data)
    {
        return preg_replace(
            [
                '/\b(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})\+(\d{2}):(\d{2})\b/',
                '#:\d{10}(,|})#',
            ],
            [
                'ISO8601_TIMESTAMP',
                ':"UNIX_TIMESTAMP"$1',
            ],
            $data
        );
    }
}
