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
    public function get($object);

    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function create($object);

    /**
     * Saves a user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function save(ApplicationUser $user);
}
