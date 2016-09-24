<?php

namespace MessageApp\Event;

use League\Event\Event;
use MessageApp\User\ApplicationUserId;

class UserCreatedEvent extends Event implements UserEvent
{
    /**
     * @var string
     */
    const NAME = 'user.created';

    /**
     * @var string
     */
    private $username;

    /**
     * @var ApplicationUserId
     */
    private $userId;

    /**
     * @var string
     */
    private $preferredLanguage;

    /**
     * Constructor
     *
     * @param ApplicationUserId $id
     * @param string            $username
     * @param string            $preferredLanguage
     */
    public function __construct(
        ApplicationUserId $id,
        $username,
        $preferredLanguage
    ) {
        parent::__construct(self::NAME);
        $this->userId = $id;
        $this->username = $username;
        $this->preferredLanguage = $preferredLanguage;
    }

    /**
     * @return ApplicationUserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPreferredLanguage()
    {
        return $this->preferredLanguage;
    }
}
