<?php

namespace MessageApp\Listener;

use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;

interface ApplicationUserFactory
{
    /**
     * Constructor
     *
     * @param ApplicationUserId $id
     * @param string            $name
     * @param string            $preferredLanguage
     *
     * @return ApplicationUser
     */
    public function create(
        ApplicationUserId $id,
        $name,
        $preferredLanguage = 'en'
    );
}
