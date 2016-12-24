<?php

namespace MessageApp\User;

use MessageApp\User\ThirdParty\Account;

interface PersistableUser
{
    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @param string $language
     */
    public function setPreferredLanguage($language);

    /**
     * @param Account $account
     */
    public function setThirdPartyAccount(Account $account);
}
