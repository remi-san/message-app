<?php

namespace MessageApp\User\Finder;

use MessageApp\User\ApplicationUser;

interface ContextUserFinder
{
    /**
     * @param  mixed $contextMessage
     * @return ApplicationUser
     */
    public function getUserByContextMessage($contextMessage);
}
