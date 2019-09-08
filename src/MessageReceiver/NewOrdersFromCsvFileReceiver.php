<?php
/**
 * Created by PhpStorm.
 * User: zero
 * Date: 07/09/19
 * Time: 3.35.
 */

namespace App\MessageReceiver;

use BluMS\Domain\Model\BluObject\Event\BluObjectWasCreated;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\TransportException;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class NewOrdersFromCsvFileReceiver implements ReceiverInterface
{
    private $serializer;
    private $filePath;

//    public function __construct(SerializerInterface $serializer, string $filePath)
//    {
//        $this->serializer = $serializer;
//        $this->filePath = $filePath;
//    }

    /**
     * Receives some messages.
     *
     * While this method could return an unlimited number of messages,
     * the intention is that it returns only one, or a "small number"
     * of messages each time. This gives the user more flexibility:
     * they can finish processing the one (or "small number") of messages
     * from this receiver and move on to check other receivers for messages.
     * If this method returns too many messages, it could cause a
     * blocking effect where handling the messages received from one
     * call to get() takes a long time, blocking other receivers from
     * being called.
     *
     * If applicable, the Envelope should contain a TransportMessageIdStamp.
     *
     * If a received message cannot be decoded, the message should not
     * be retried again (e.g. if there's a queue, it should be removed)
     * and a MessageDecodingFailedException should be thrown.
     *
     * @throws TransportException If there is an issue communicating with the transport
     *
     * @return Envelope[]
     */
    public function get(): iterable
    {
        //$ordersFromCsv = $this->serializer->deserialize(file_get_contents($this->filePath), 'csv');
        $ordersFromCsv = [1, 1];

        foreach ($ordersFromCsv as $orderFromCsv) {
            //$order = new NewOrder($orderFromCsv['id'], $orderFromCsv['account_id'], $orderFromCsv['amount']);

            $order = new BluObjectWasCreated('1', 'blu object');
            $envelope = new Envelope($order);

            $handler($envelope);
        }

        return [$envelope];
    }

    /**
     * Acknowledges that the passed message was handled.
     *
     * @throws TransportException If there is an issue communicating with the transport
     */
    public function ack(Envelope $envelope): void
    {
        // TODO: Implement ack() method.
    }

    /**
     * Called when handling the message failed and it should not be retried.
     *
     * @throws TransportException If there is an issue communicating with the transport
     */
    public function reject(Envelope $envelope): void
    {
        // TODO: Implement reject() method.
    }
}
