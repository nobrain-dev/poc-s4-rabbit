<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\Integration\ACL\Consumer;

use Exception;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Swarrot\Broker\Message;
use Swarrot\Processor\ProcessorInterface;

class GreenSwarrotACLConsumer implements ProcessorInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * OrderCreate1Consumer constructor.
     *
     * @param $logger
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
    }





    /**
     * Process a message.
     * Return false to stop processing messages.
     *
     * @param Message $message The message given by a MessageProvider
     * @param array $options An array containing all parameters
     *
     * @return bool|null
     */
    public function process(Message $message, array $options)
    {
        // TODO: Implement process() method.
        // TODO: Implement execute() method.

        $body = json_decode($message->getBody(), true);

        try {
            // Application log

            //var_dump($body);
            $this->log(json_encode($body));

            // STD_OUTPUT
            //echo sprintf('Order create 1 - ID:%s @ %s ...', $body['order_id'], date('Y-m-d H:i:s')).PHP_EOL;
            echo sprintf('--- SWARROT -- Blu Anti Corruption Layer from Green Bounded Contect - EVENT ID:%s @ %s ...', $body['event_id'], date('Y-m-d H:i:s')).PHP_EOL;
            echo json_encode($options).PHP_EOL;
            echo json_encode($message).PHP_EOL;
            echo json_encode($body).PHP_EOL;
        } catch (Exception $e) {
            $this->logError($message, $e->getMessage());

            return false;
        }
    }


    private function log($message)
    {
//        $log = new OrderLog();
//        $log->setAction(OrderLog::CREATE);
//        $log->setMessage($message);
//
//        $this->entityManager->persist($log);
//        $this->entityManager->flush();

        $this->logger->info($message);
    }

    private function logError($message, $error)
    {
        $data = [
            'error' => $error,
            'class' => __CLASS__,
            'message' => $message,
        ];

        $this->logger->error(json_encode($data));
    }


}
