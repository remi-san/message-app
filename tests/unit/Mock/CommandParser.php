<?php

namespace MessageApp\Test\Mock;

use MessageApp\Parser\CommandParserTrait;
use MessageApp\User\ApplicationUser;

class CommandParser
{
    use CommandParserTrait;

    public function testableCheckUser(ApplicationUser $user)
    {
        $this->checkUser($user);
    }
}