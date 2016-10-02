<?php

namespace MessageApp\Parser;

use MessageApp\User\ApplicationUserId;
use Twitter\Object\TwitterUser;

interface ParsingUserFactory
{
    /**
     * @param ApplicationUserId $userId
     * @param TwitterUser       $twitterUser
     * @param string            $language
     *
     * @return ParsingUser
     */
    public function createParsingUser(ApplicationUserId $userId, TwitterUser $twitterUser, $language);
}
