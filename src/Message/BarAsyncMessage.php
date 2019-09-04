<?php

declare(strict_types=1);

namespace App\Message;

class BarAsyncMessage
{
    /** @var string */
    private $alpha;

    /** @var string */
    private $beta;

    /**
     * FooSyncMessage constructor.
     *
     * @param string $alpha
     * @param string $beta
     */
    public function __construct(string $alpha, string $beta)
    {
        $this->alpha = $alpha;
        $this->beta = $beta;
    }

    /**
     * @return string
     */
    public function alpha(): string
    {
        return $this->alpha;
    }

    /**
     * @return string
     */
    public function beta(): string
    {
        return $this->beta;
    }
}
