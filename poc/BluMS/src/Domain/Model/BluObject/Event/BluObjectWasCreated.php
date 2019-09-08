<?php

declare(strict_types=1);

namespace BluMS\Domain\Model\BluObject\Event;

class BluObjectWasCreated implements publicEventInterface
{
    const NAME = 'blu.object_created';

    /** @var string */
    private $bluObjectId;

    /** @var string */
    private $name;

    /**
     * BluObjectWasCreated constructor.
     *
     * @param string $bluObjectId
     * @param string $name
     */
    public function __construct(string $bluObjectId, string $name)
    {
        $this->bluObjectId = $bluObjectId;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function bluObjectId(): string
    {
        return $this->bluObjectId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function eventName(): string
    {
        return self::NAME;
    }

    public function __toArray(): array
    {
        return [
            'blu_object_id' => $this->bluObjectId(),
            'name' => $this->name(),
        ];
    }
}
