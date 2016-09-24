<?php

namespace MessageApp\User\Repository;

use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Exception\AppUserException;

interface ApplicationUserRepository
{
    /**
     * Retrieves an application user
     *
     * @param  ApplicationUserId $id
     *
     * @throws AppUserException
     * @return SourcedUser
     */
    public function load(ApplicationUserId $id);

    /**
     * Saves a user
     *
     * @param  SourcedUser $user
     *
     * @return void
     */
    public function save(SourcedUser $user);
}
