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
     * @var string
     */
    private $reason;

    /**
     * Constructor
     *
     * @param UndefinedApplicationUser $user
     * @param string                   $reason
     */
    public function __construct(UndefinedApplicationUser $user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * @return UndefinedApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
}
