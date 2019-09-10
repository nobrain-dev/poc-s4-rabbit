<?php

declare(strict_types=1);

namespace RedMS\Domain\Model\Event;

use Assert\Assertion;
use Prooph\Common\Messaging\DomainEvent;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class NewRedObjectCreated extends DomainEvent implements PayloadConstructable
{
    use PayloadTrait;

    protected $messageName = 'red.object-was-created';

    public static function withData(string $redObjectId, string $name, string $link): NewRedObjectCreated
    {
        return new self([
            'red_object_id' => $redObjectId,
            'name' => $name,
            'link' => $link,
        ]);
    }

    public function redObjectId(): string
    {
        return $this->payload['red_object_id'];
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
        Assertion::keyExists($payload, 'red_object_id');
        Assertion::string($payload['red_object_id']);

        Assertion::keyExists($payload, 'name');
        Assertion::string($payload['name']);

        Assertion::keyExists($payload, 'link');
        Assertion::string($payload['link']);

        $this->payload = $payload;
    }
}
