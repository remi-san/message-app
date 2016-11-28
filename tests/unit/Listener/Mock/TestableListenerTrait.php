<?php

namespace MessageApp\Test\Listener\Mock;

use MessageApp\Listener\ListenerTrait;

class TestableListenerTrait
{
    use ListenerTrait;

    /** @var TestEvent */
    public $receivedEvent;

    public function handleTestEvent(TestEvent $event)
    {
        $this->receivedEvent = $event;
    }
}
