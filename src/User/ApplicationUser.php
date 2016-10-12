<?php

namespace MessageApp\User;

use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\Source;

interface ApplicationUser
{
    /**
     * Returns the id
     *
     * @return ApplicationUserId
     */
    public function getId();

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * Returns the preferred language
     *
     * @return string
     */
    public function getPreferredLanguage();

    /**
     * @param string $language
     */
    public function setPreferredLanguage($language);

    /**
     * @param Source $source
     *
     * @return Account
     */
    public function getThirdPartyAccount(Source $source);

    /**
     * @param Account $account
     */
    public function setThirdPartyAccount(Account $account);
}
