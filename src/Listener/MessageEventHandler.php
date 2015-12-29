<?php
namespace MessageApp\Listener;

use League\Event\EventInterface;
use MessageApp\Message;

interface MessageEventHandler
{
    /**
     * Handle an event.
     *
     * @param EventInterface $event
     * @param mixed          $context
     *
     * @return void
     */
    public function handle(EventInterface $event, $context = null);
}
