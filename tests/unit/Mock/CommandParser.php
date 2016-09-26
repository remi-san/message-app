<?php

namespace MessageApp\Test\Mock;

use MessageApp\Parser\CommandParserTrait;
use MessageApp\Parser\ParsingUser;

class CommandParser
{
    use CommandParserTrait;

    public function testableCheckUser(ParsingUser $user)
    {
        $this->checkUser($user);
    }
}