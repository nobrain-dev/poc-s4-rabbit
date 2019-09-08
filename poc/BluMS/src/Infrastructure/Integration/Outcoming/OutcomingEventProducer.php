<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\Integration\Outcoming;

use BluMS\Domain\Model\BluObject\Event\publicEventInterface;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class OutcomingEventProducer
{
    /** @var ProducerInterface */
    private $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
        $this->producer->setContentType('application/json');
    }

    public function add(publicEventInterface $event)
    {
        $message = [
            //'event_id' => $order->getId(),
            'event_name' => $event->eventName(),
            'event_body' => json_encode($event->__toArray()),
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        $this->producer->publish(json_encode($message), $event->eventName());
    }
}
