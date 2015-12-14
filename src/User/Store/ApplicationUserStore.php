<?php
namespace MessageApp\User\Store;

use MessageApp\User\ApplicationUser;

interface ApplicationUserStore
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
     * Saves a mini game
     *
     * @param  ApplicationUser $game
     *
     * @return void
     */
    public function save(ApplicationUser $game);
}
