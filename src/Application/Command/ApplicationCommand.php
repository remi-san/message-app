<?php
namespace MessageApp\Application\Command;

use MessageApp\ApplicationUser;

interface ApplicationCommand {

    /**
     * Returns the user
     *
     * @return ApplicationUser
     */
    public function getUser();
} 