<?php

namespace MessageApp\User;

use MessageApp\User\Entity\SourcedUser;
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
     * @return SourcedUser
     * @throws AppUserException
     */
    public function create(ApplicationUserId $userId, $object, $language);
}
