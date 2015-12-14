<?php
namespace MessageApp\Test\Mock;

use Broadway\Domain\DomainMessage;
use League\Event\EventInterface;
use MessageApp\User\Manager\AbstractUserManager;

class AbstractUserManagerMock extends AbstractUserManager
{
    /**
     * Prepares the event to return a League Event
     *
     * @param  DomainMessage $originalEvent
     * @return EventInterface
     */
    protected function prepareEvent($originalEvent)
    {
        return $originalEvent->getPayload();
    }
}
