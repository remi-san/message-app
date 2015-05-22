<?php
namespace MessageApp\User;

use MessageApp\ApplicationUser;

interface ApplicationUserManager
{
    /**
     * Retrieves an application user
     *
     * @param  object $object
     * @return ApplicationUser
     */
    public function getUser($object);

    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
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