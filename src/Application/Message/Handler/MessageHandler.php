<?php
namespace MessageApp\Application\Message\Handler;

use MessageApp\Application\Message;

interface MessageHandler
{
    /**
     * Handle response
     *
     * @param  Message $message
     * @param  object  $context
     * @return void
     */
    public function handle(Message $message = null, $context = null);
}
