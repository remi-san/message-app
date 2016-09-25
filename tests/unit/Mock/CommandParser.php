<?php

namespace MessageApp\Test\Mock;

use MessageApp\Parser\CommandParserTrait;
use MessageApp\Parser\LocalizedUser;

class CommandParser
{
    use CommandParserTrait;

    public function testableCheckUser(LocalizedUser $user)
    {
        $this->checkUser($user);
    }
}