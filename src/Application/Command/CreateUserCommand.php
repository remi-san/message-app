<?php
namespace MessageApp\Application\Command;

use MessageApp\ApplicationUser;

class CreateUserCommand implements ApplicationCommand
{
    const NAME = 'USER.CREATE';

    /**
     * @var ApplicationUser
     */
    private $user;

    /**
     * Constructor
     *
     * @param ApplicationUser $user
     */
    public function __construct(ApplicationUser $user)
    {
        $this->user = $user;
    }

    /**
     * Returns the command name
     *
     * @return string
     */
    public function getCommandName()
    {
        return self::NAME;
    }

    /**
     * Returns the user
     *
     * @return ApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }
}
