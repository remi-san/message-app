<?php

namespace Parser;

use MessageApp\Parser\ParsingUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\ThirdParty\Account;

class UndefinedParsingUser implements ParsingUser
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * Constructor
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * Returns the id
     *
     * @return ApplicationUserId
     */
    public function getId()
    {
        return null;
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return null;
    }

    /**
     * Returns the preferred language
     *
     * @return string
     */
    public function getPreferredLanguage()
    {
        return 'en';
    }

    /**
     * Get the account
     *
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Is the user defined
     *
     * @return boolean
     */
    public function isDefined()
    {
        return false;
    }
}
