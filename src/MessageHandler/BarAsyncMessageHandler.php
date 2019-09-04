<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\BarAsyncMessage;

class BarAsyncMessageHandler
{
    public function __invoke(BarAsyncMessage $message)
    {
        // ... do some work - like sending an SMS message!
        echo sprintf('The Bar message with "%s"  and  "%s" is recived...'.PHP_EOL, $message->alpha(), $message->beta());
        sleep(2); // Assume than message resizing takes 2 seconds
        echo 'The message has been consumed!'.PHP_EOL;
        echo 'Moving on to next message in the queue.'.PHP_EOL.PHP_EOL;
    }
}
