<?php

declare(strict_types=1);

namespace GreenMS\Domain\Model\Event;

use Assert\Assertion;
use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class NewGreenObjectCreated extends DomainEvent implements PayloadConstructable
{
    use PayloadTrait;

    protected $messageName = 'green.object-was-created';

    public static function withData(string $greenObjectId, string $name, string $link): NewGreenObjectCreated
    {
        return new self([
            'green_object_id' => $greenObjectId,
            'name' => $name,
            'link' => $link,
        ]);
    }

    public function greenObjectId(): string
    {
        return $this->payload['green_object_id'];
    }

    public function name(): string
    {
        return $this->payload['name'];
    }

    public function link(): string
    {
        return $this->payload['link'];
    }

    /**
     * @param array $payload
     *
     * @throws \Assert\AssertionFailedException
     */
    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'green_object_id');
        Assertion::string($payload['green_object_id']);

        Assertion::keyExists($payload, 'name');
        Assertion::string($payload['name']);

        Assertion::keyExists($payload, 'link');
        Assertion::string($payload['link']);

        $this->payload = $payload;
    }
}
