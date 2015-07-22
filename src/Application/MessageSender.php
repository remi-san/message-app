<?php
namespace MessageApp\Application;

interface MessageSender
{

    /**
     * Send a message
     *
     * @param  Message $message
     * @param  object  $context
     * @return void
     */
    public function send(Message $message, $context);
} 