<?php

namespace MessageApp\Event;

use League\Event\Event;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\ThirdParty\Account;

class ThirdPartyAccountReplacedEvent extends Event
{
    /**
     * @var string
     */
    const NAME = 'user.3rd-party.replaced';

    /** @var ApplicationUserId */
    private $userId;

    /** @var Account */
    private $thirdPartyAccount;

    /**
     * ThirdPartyAccountLinkedEvent constructor.
     *
     * @param ApplicationUserId $userId
     * @param Account           $thirdPartyAccount
     */
    public function __construct(ApplicationUserId $userId, Account $thirdPartyAccount)
    {
        parent::__construct(self::NAME);
        $this->userId = $userId;
        $this->thirdPartyAccount = $thirdPartyAccount;
    }

    /**
     * @return ApplicationUserId
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return Account
     */
    public function getThirdPartyAccount()
    {
        return $this->thirdPartyAccount;
    }
}
