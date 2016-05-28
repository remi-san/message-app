<?php

namespace MessageApp\Parser;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\User\ApplicationUser;
use MessageApp\User\UndefinedApplicationUser;

trait CommandParserTrait
{
    /**
     * @param ApplicationUser $user
     * @throws MessageParserException
     */
    protected function checkUser(ApplicationUser $user)
    {
        if ($user instanceof UndefinedApplicationUser) {
            throw new MessageParserException(
                $user,
                'User is not valid!'
            );
        }
    }
}
