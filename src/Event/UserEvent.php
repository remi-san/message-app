<?php
namespace MessageApp\Event;

use MessageApp\User\ApplicationUserId;

interface UserdEvent
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
