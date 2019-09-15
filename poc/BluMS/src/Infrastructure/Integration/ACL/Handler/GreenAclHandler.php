<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\Integration\ACL\Handler;


use Exception;
use Psr\Log\LoggerInterface;

class GreenAclHandler
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * GreenAclHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public function __invoke()
    {
        // TODO: Implement execute() method.

        $body = json_decode($message->body, true);

        try {
            // Application log

            //var_dump($body);
            $this->log(json_encode($body));

            // STD_OUTPUT
            //echo sprintf('Order create 1 - ID:%s @ %s ...', $body['order_id'], date('Y-m-d H:i:s')).PHP_EOL;
            echo sprintf('Blu Anti Corruption Layer from Green Bounded Contect - EVENT ID:%s @ %s ...', $body['event_id'], date('Y-m-d H:i:s')).PHP_EOL;
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