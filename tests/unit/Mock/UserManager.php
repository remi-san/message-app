<?php
namespace MessageApp\Test\Mock;

use MessageApp\User\InMemoryUserManager;

class UserManager extends InMemoryUserManager
{
    use MessageAppMocker;

    public function create($object)
    {
        return $this->getApplicationUser(1, 'player');
    }

    protected function getUserId($object)
    {
        return $object->getId();
    }

    protected function supports($object)
    {
        return $object !== null;
    }
}
