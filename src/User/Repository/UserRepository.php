<?php

namespace MessageApp\User\Repository;

use MessageApp\Exception\MessageAppException;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;

interface UserRepository
{
    /**
     * Retrieves an application user
     *
     * @param  ApplicationUserId $id
     *
     * @throws MessageAppException
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
