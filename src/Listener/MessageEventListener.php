<?php
namespace MessageApp\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;

class MessageEventListener extends AbstractListener
{
    /**
     * @var MessageEventHandler
     */
    private $handler;

    /**
     * Constructor
     *
     * @param MessageEventHandler $handler
     */
    public function __construct(MessageEventHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        $context = null;

        $this->handler->handle($event, $context);
    }
}
