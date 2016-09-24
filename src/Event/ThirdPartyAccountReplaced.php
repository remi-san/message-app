<?php

namespace MessageApp\Event;

use League\Event\Event;
use MessageApp\User\ThirdParty\User;

class ThirdPartyAccountReplaced extends Event
{
    /**
     * @var string
     */
    const NAME = 'user.3rd-party.replaced';

    /** @var User */
    private $thirdPartyUser;

    /**
     * ThirdPartyAccountLinked constructor.
     *
     * @param User $thirdPartyUser
     */
    public function __construct(User $thirdPartyUser)
    {
        parent::__construct(self::NAME);
        $this->thirdPartyUser = $thirdPartyUser;
    }

    /**
     * @return User
     */
    public function getThirdPartyUser()
    {
        return $this->thirdPartyUser;
    }
}
