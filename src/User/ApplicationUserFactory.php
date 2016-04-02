<?php

namespace MessageApp\User;

use MessageApp\User\Exception\AppUserException;

interface ApplicationUserFactory
{
    /**
     * Creates an application user
     *
     * @param  object $object
     * @throws AppUserException
     * @return ApplicationUser
     */
    public function create($object);
}
