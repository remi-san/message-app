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
     * Returns the preferred language
     *
     * @return string
     */
    public function getPreferredLanguage();

    /**
     * @param Source $source
     *
     * @return Account
     */
    public function getThirdPartyAccount(Source $source);
}
