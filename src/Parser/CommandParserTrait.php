<?php

namespace MessageApp\Parser;

use MessageApp\Parser\Exception\MessageParserException;

trait CommandParserTrait
{
    /**
     * @param ParsingUser $user
     *
*@throws MessageParserException
     */
    protected function checkUser(ParsingUser $user)
    {
        if (! $user->isDefined()) {
            throw MessageParserException::invalidUser($user);
        }
    }
}
