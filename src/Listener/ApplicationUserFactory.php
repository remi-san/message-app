<?php

namespace MessageApp\Listener;

use MessageApp\User\ApplicationUserId;

interface ApplicationUserFactory
{
    /**
     * Constructor
     *
     * @param ApplicationUserId $id
     * @param string            $name
     * @param string            $preferredLanguage
     */
    public function create(
        ApplicationUserId $id,
        $name,
        $preferredLanguage = 'en'
    );
}
