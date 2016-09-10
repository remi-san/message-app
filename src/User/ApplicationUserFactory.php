<?php

namespace MessageApp\User;

use MessageApp\User\Exception\AppUserException;

interface ApplicationUserFactory
{
    /**
     * Creates an application user
     *
     * @param ApplicationUserId $userId
     * @param  object           $object
     * @param  string           $language
     *
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function create(ApplicationUserId $userId, $object, $language);
}
