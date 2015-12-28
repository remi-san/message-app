<?php
namespace MessageApp\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;

class UserEventListener extends AbstractListener
{
    /**
     * @var UserEventHandler
     */
    private $handler;

    /**
     * Constructor
     *
     * @param UserEventHandler $handler
     */
    public function __construct(UserEventHandler $handler)
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
