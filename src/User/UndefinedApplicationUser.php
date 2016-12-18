<?php

namespace MessageApp\User;

use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\Source;

class UndefinedApplicationUser implements ApplicationUser
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
        if ($source != $this->account->getSource()) {
            return null;
        }

        return $this->account;
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
