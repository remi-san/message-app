<?php
namespace MessageApp\Listener;

use League\Event\EventInterface;
use MessageApp\Message;
use RemiSan\Command\Context;

interface MessageEventHandler
{
    /**
     * Handle an event.
     *
     * @param EventInterface $event
     * @param Context        $context
     *
     * @return void
     */
    public function handle(EventInterface $event, Context $context = null);
}
