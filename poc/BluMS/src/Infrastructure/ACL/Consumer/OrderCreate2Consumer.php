<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\ACL\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class OrderCreate2Consumer implements ConsumerInterface
{
    private $logger;

    /**
     * OrderCreate2Consumer constructor.
     *
     * @param $logger
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param AMQPMessage $message The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $message)
    {
        // TODO: Implement execute() method.

        $body = json_decode($message->body, true);

        try {
            // Application log
            $this->log($body);
            // STD_OUTPUT
            echo sprintf('Order create 1 - ID:%s @ %s ...', $body['order_id'], date('Y-m-d H:i:s')).PHP_EOL;
            echo json_encode($message).PHP_EOL;
        } catch (Exception $e) {
            $this->logError($message, $e->getMessage());
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
