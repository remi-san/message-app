<?php

namespace MessageApp\Message;

use MessageApp\Message;
use MessageApp\User\ApplicationUser;

class DefaultMessage implements Message
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var ApplicationUser
     */
    protected $user;

    /**
     * Construct
     *
     * @param ApplicationUser $user
     * @param string          $message
     */
    public function __construct(ApplicationUser $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
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

    /**
     * Returns the user the message must be sent to
     *
     * @return ApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
