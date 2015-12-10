<?php
namespace MessageApp\Test\Mock;

use MessageApp\User\Manager\InDatabaseUserManager;

class InDatabaseUserManagerMock extends InDatabaseUserManager
{
    use MessageAppMocker;

    public function create($object)
    {
        return $this->getApplicationUser($this->getApplicationUserId(1), 'player');
    }
}
