<?php

namespace MessageApp\Listener;

use League\Event\EventInterface;

trait ListenerTrait
{
    /**
     * @inheritDoc
     */
    public function handle(EventInterface $event)
    {
        $method = $this->getHandleMethod($event);

        if (! method_exists($this, $method)) {
            return;
        }

        $this->$method($event);
    }

    private function getHandleMethod(EventInterface $event)
    {
        $classParts = explode('\\', get_class($event));

        return 'handle' . end($classParts);
    }

    /**
     * @inheritDoc
     */
    public function isListener($listener)
    {
        return $listener === $this;
    }
}
