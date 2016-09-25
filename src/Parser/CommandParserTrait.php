<?php

namespace MessageApp\Parser;

use MessageApp\Parser\Exception\MessageParserException;

trait CommandParserTrait
{
    /**
     * @param LocalizedUser $user
     * @throws MessageParserException
     */
    protected function checkUser(LocalizedUser $user)
    {
        if (! $user->isDefined()) {
            throw MessageParserException::invalidUser($user);
        }
    }
}
