<?php

declare(strict_types=1);

namespace GreenMS\Infrastructure\Integration\Outcoming;

use Prooph\Common\Messaging\DomainEvent;
use Swarrot\SwarrotBundle\Broker\Publisher;
use Swarrot\Broker\Message;

class GreenIntegrationSwarrotEventPublisher
{
    /** @var Publisher */
    private $publisher;

    /**
     * GreenIntegrationEventPublisher constructor.
     *
     * @param Publisher $publisher
     */
    public function __construct(Publisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function publish(DomainEvent $event): void
    {
        $messageEvent = [
            'event_id' => $event->uuid(),
            'event_name' => $event->messageName(),
            'event_body' => json_encode($event->payload()),
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        $message = new Message(json_encode($messageEvent));

        $this->publisher->publish('green_integration_publisher', $message, [
            //'exchange'    => 'my_new_echange',
            //'connection'  => 'my_second_connection',
            'routing_key' => $event->messageName(),
        ]);
    }
}
