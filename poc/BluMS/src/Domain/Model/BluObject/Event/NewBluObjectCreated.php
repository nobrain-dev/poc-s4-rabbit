<?php

declare(strict_types=1);

namespace BluMS\Domain\Model\BluObject\Event;

use Assert\Assertion;
use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class NewBluObjectCreated extends DomainEvent implements PayloadConstructable
{
    use PayloadTrait;

    protected $messageName = 'blu.object-was-created';

    public static function withData(string $bluObjectId, string $name, string $link): NewBluObjectCreated
    {
        return new self([
            'blu_object_id' => $bluObjectId,
            'name' => $name,
            'link' => $link,
        ]);
    }

    public function bluObjectId(): string
    {
        return $this->payload['blu_object_id'];
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
        Assertion::keyExists($payload, 'blu_object_id');
        Assertion::string($payload['blu_object_id']);

        Assertion::keyExists($payload, 'name');
        Assertion::string($payload['name']);

        Assertion::keyExists($payload, 'link');
        Assertion::string($payload['link']);

        $this->payload = $payload;
    }
}
