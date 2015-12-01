<?php
namespace MessageApp\Application\Command;

use League\Tactician\Plugins\NamedCommand\NamedCommand;

class CreateUserCommand implements NamedCommand
{
    const NAME = 'USER.CREATE';

    /**
     * @var object
     */
    private $originalUser;

    /**
     * Constructor
     *
     * @param object $originalUser
     */
    public function __construct($originalUser)
    {
        $this->originalUser = $originalUser;
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
     * @return object
     */
    public function getOriginalUser()
    {
        return $this->originalUser;
    }
}
