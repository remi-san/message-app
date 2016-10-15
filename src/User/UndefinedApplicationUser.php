<?php

namespace MessageApp\User;

use MessageApp\Parser\ParsingUser;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\Source;

class UndefinedApplicationUser implements ApplicationUser, ParsingUser
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
     * @param Source $source
     *
     * @return Account
     */
    public function getThirdPartyAccount(Source $source)
    {
        return $this->account; // TODO check source
    }

    /**
     * @inheritDoc
     */
    public function isDefined()
    {
        return false;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
    }

    /**
     * @param string $language
     */
    public function setPreferredLanguage($language)
    {
    }

    /**
     * @param Account $account
     */
    public function setThirdPartyAccount(Account $account)
    {
    }
}
