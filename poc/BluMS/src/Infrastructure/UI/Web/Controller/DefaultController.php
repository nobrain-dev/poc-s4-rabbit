<?php

declare(strict_types=1);

namespace BluMS\Infrastructure\UI\Web\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DefaultController
{
    private $entityManager;
    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param array $newOrder
     *
     * @return Order
     */
    public function create(array $newOrder)
    {
//        $order = new Order();
//        $order->setCustomerName($newOrder['customer_name']);
//        $order->setCarMake($newOrder['car_make']);
//        $order->setCarModel($newOrder['car_model']);
//
//        $this->entityManager->persist($order);
//        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(OrderEvent::CREATE, new OrderEvent($order));

        return $order->getId();
    }
}
