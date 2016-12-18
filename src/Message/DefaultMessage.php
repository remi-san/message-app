<?php

namespace MessageApp\Message;

use MessageApp\Message;
use MessageApp\User\ApplicationUser;

class DefaultMessage implements Message
{
    /**
     * @var ApplicationUser[]
     */
    protected $users;

    /**
     * @var string
     */
    protected $message;

    /**
     * Construct
     *
     * @param ApplicationUser[] $users
     * @param string            $message
     */
    public function __construct(array $users, $message)
    {
        $this->users = $users;
        $this->message = $message;
    }

    /**
     * Returns the user the message must be sent to
     *
     * @return ApplicationUser[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Returns the message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
