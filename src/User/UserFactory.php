<?php

namespace MessageApp\User;

use MessageApp\Exception\MessageAppException;
use MessageApp\User\Entity\SourcedUser;

interface UserFactory
{
    /**
     * Creates an application user
     *
     * @param  ApplicationUserId $userId
     * @param  object            $object
     * @param  string            $language
     *
     * @throws MessageAppException
     * @return SourcedUser
     */
    public function create(ApplicationUserId $userId, $object, $language);
}
