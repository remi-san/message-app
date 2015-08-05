<?php
namespace MessageApp\Test\Mock;

use MessageApp\ApplicationUser;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\InMemoryUserManager;

class UserManager extends InMemoryUserManager
{
    use MessageAppMocker;

    public function create($object)
    {
        return $this->getApplicationUser($this->getApplicationUserId(1), 'player');
    }

    /**
     * Retrieves a player
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function getByObject($object)
    {
        return $object;
    }
}
