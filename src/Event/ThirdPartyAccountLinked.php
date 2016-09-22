<?php

namespace MessageApp\Event;

use MessageApp\User\ThirdParty\User;

class ThirdPartyAccountLinked
{
    /** @var User */
    private $thirdPartyUser;

    /**
     * ThirdPartyAccountLinked constructor.
     *
     * @param User $thirdPartyUser
     */
    public function __construct(User $thirdPartyUser)
    {
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
