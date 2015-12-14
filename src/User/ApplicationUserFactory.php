<?php
namespace MessageApp\User;

use MessageApp\User\Exception\AppUserException;

interface ApplicationUserFactory
{
    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function create($object);
}
