<?php

namespace MessageApp\User\Repository;

use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Exception\AppUserException;

interface ApplicationUserRepository
{
    /**
     * Retrieves an application user
     *
     * @param  ApplicationUserId $id
     * @throws AppUserException
     * @return ApplicationUser
     */
    public function load(ApplicationUserId $id);

    /**
     * Saves a user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function save(ApplicationUser $user);
}
