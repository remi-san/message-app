<?php

namespace MessageApp\Test\Listener\Mock;

use League\Event\Event;

class TestEvent extends Event
{
    /**
     * TestEvent constructor.
     */
    public function __construct()
    {
        parent::__construct('test');
    }
}
