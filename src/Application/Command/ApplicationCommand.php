<?php
namespace MessageApp\Application\Command;

use MessageApp\ApplicationUser;

interface ApplicationCommand {

    /**
     * @return \MessageApp\ApplicationUser
     */
    public function getUser();
} 