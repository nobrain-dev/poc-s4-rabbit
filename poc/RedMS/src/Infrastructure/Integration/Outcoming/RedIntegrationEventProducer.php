<?php

declare(strict_types=1);

namespace RedMS\Infrastructure\Integration\Outcoming;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Prooph\Common\Messaging\DomainEvent;

class RedIntegrationEventProducer
{
    /** @var ProducerInterface */
    private $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
        $this->producer->setContentType('application/json');
    }

    public function add(DomainEvent $event)
    {
        $message = [
            'event_id' => $event->uuid(),
            'event_name' => $event->messageName(),
            'event_body' => json_encode($event->payload()),
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        $this->producer->publish(json_encode($message), $event->messageName());
    }
}
