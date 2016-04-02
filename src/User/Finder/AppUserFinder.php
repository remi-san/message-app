<?php

namespace MessageApp\User\Finder;

use MessageApp\User\ApplicationUser;

interface AppUserFinder
{
    /**
     * Finds an user by its primary key / identifier.
     *
     * @param  string $id The identifier.
     *
     * @return ApplicationUser The user.
     */
    public function find($id);

    /**
     * @param  ApplicationUser $user
     * @return void
     */
    public function save(ApplicationUser $user);
}
