<?php

namespace MessageApp\Event;

use League\Event\Event;
use MessageApp\User\UndefinedApplicationUser;

class UnableToCreateUserEvent extends Event
{
    /**
     * @var string
     */
    const NAME = 'user.failed-creating';

    /**
     * @var UndefinedApplicationUser
     */
    private $user;

    /**
     * Constructor
     *
     * @param UndefinedApplicationUser $user
     */
    public function __construct(UndefinedApplicationUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return UndefinedApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
