<?php

namespace MessageApp;

use MessageApp\User\ApplicationUser;

interface Message
{
    /**
     * Returns the user the message must be sent to
     *
     * @return ApplicationUser[]
     */
    public function getUsers();

    /**
     * Returns the message
     *
     * @return string
     */
    public function getMessage();
}
