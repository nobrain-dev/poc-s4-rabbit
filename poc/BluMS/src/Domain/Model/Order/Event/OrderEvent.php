<?php

declare(strict_types=1);

namespace BluMS\Domain\Model\Order\Event;

use Symfony\Contracts\EventDispatcher\Event;

class OrderEvent extends Event
{
    const CREATE = 'application_frontend.event.order_create';

    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
