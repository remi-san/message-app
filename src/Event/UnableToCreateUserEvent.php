<?php

namespace MessageApp\Event;

use League\Event\Event;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\UndefinedApplicationUser;

class UnableToCreateUserEvent extends Event
{
    /**
     * @var string
     */
    const NAME = 'user.failed-creating';

    /** @var ApplicationUserId */
    private $userId;

    /**
     * @var UndefinedApplicationUser
     */
    private $user;

    /**
     * Constructor
     *
     * @param ApplicationUserId        $userId
     * @param UndefinedApplicationUser $user
     */
    public function __construct(
        ApplicationUserId $userId,
        UndefinedApplicationUser $user
    ) {
        parent::__construct(self::NAME);

        $this->userId = $userId;
        $this->user = $user;
    }

    /**
     * @return ApplicationUserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return UndefinedApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
