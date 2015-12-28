<?php
namespace MessageApp\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;

class UnableToCreateUserEventListener extends AbstractListener
{
    /**
     * @var UnableToCreateUserEventHandler
     */
    private $handler;

    /**
     * Constructor
     *
     * @param UnableToCreateUserEventHandler $handler
     */
    public function __construct(UnableToCreateUserEventHandler $handler)
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
