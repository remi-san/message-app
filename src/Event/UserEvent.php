<?php
namespace MessageApp\Event;

use League\Event\EventInterface;
use MessageApp\User\ApplicationUserId;

interface UserEvent extends EventInterface
{
    /**
     * @return ApplicationUserId
     */
    public function getUserId();

    /**
     * @return string
     */
    public function getAsMessage();
}
