<?php
namespace MessageApp\Application\Command;

use Command\Command;
use MessageApp\ApplicationUser;

interface ApplicationCommand extends Command {

    /**
     * Returns the user
     *
     * @return ApplicationUser
     */
    public function getUser();
} 