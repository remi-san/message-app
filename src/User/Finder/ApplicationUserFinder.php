<?php

namespace MessageApp\User\Finder;

use MessageApp\User\ApplicationUser;

interface ApplicationUserFinder
{
    /**
     * Finds an user by its primary key / identifier.
     *
     * @param  string $id The identifier.
     *
     * @return ApplicationUser The user.
     */
    public function find($id);
}
