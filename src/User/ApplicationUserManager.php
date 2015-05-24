<?php
namespace MessageApp\User;

use MessageApp\ApplicationUser;
use MessageApp\User\Exception\AppUserException;

interface ApplicationUserManager
{
    /**
     * Retrieves an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function getUser($object);

    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function createUser($object);

    /**
     * Saves a user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function saveUser(ApplicationUser $user);
} 