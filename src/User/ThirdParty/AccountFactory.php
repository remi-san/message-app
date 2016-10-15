<?php

namespace MessageApp\User\ThirdParty;

interface AccountFactory
{
    /**
     * @param mixed $originalUser
     *
     * @return Account
     */
    public function build($originalUser);
}
