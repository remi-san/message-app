<?php
namespace MessageApp\Application\Command;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\ApplicationUser;

interface ApplicationCommand extends NamedCommand
{
    /**
     * Returns the user
     *
     * @return ApplicationUser
     */
    public function getUser();
}
