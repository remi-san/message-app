<?php
namespace MessageApp\User\Manager;

use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Exception\AppUserException;

interface ApplicationUserManager
{
    /**
     * Retrieves an application user
     *
     * @param  ApplicationUserId $id
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function get(ApplicationUserId $id);

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