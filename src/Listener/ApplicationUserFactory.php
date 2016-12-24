<?php

namespace MessageApp\Listener;

use MessageApp\User\ApplicationUserId;
use MessageApp\User\PersistableUser;

interface ApplicationUserFactory
{
    /**
     * Constructor
     *
     * @param ApplicationUserId $id
     * @param string            $name
     * @param string            $preferredLanguage
     *
     * @return PersistableUser
     */
    public function create(
        ApplicationUserId $id,
        $name,
        $preferredLanguage = 'en'
    );
}
