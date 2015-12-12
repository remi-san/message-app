<?php
namespace MessageApp\Test\Mock;

use MessageApp\User\Manager\AbstractUserManager;

class AbstractUserManagerMock extends AbstractUserManager
{
    use MessageAppMocker;

    public function create($object)
    {
        return $this->getApplicationUser($this->getApplicationUserId(1), 'player');
    }
}
