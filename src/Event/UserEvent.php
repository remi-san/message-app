<?php
namespace MessageApp\Event;

use MessageApp\User\ApplicationUserId;

interface UserEvent
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
