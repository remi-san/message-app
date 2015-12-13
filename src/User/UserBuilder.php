<?php
namespace MessageApp\User;

use MessageApp\User\Exception\AppUserException;

interface UserBuilder
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
