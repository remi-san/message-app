<?php

namespace MessageApp\User\Store;

use MessageApp\User\PersistableUser;

interface ApplicationUserStore
{
    /**
     * Finds an user by its primary key / identifier.
     *
     * @param  string $id The identifier.
     *
     * @return PersistableUser The user.
     */
    public function find($id);

    /**
     * @param  PersistableUser $user
     * @return void
     */
    public function save(PersistableUser $user);
}
