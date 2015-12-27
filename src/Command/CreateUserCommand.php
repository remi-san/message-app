<?php
namespace MessageApp\Command;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use RemiSan\Command\Origin;
use RemiSan\Command\OriginAwareCommand;

class CreateUserCommand implements NamedCommand, OriginAwareCommand
{
    const NAME = 'USER.CREATE';

    /**
     * @var object
     */
    private $originalUser;

    /**
     * @var Origin
     */
    private $origin;

    /**
     * Constructor
     *
     * @param object $originalUser
     * @param Origin $origin
     */
    public function __construct($originalUser, Origin $origin = null)
    {
        $this->originalUser = $originalUser;
        $this->origin = $origin;
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

    /**
     * Returns the origin
     *
     * @return Origin
     */
    public function getOrigin()
    {
        return $this->origin;
    }
}
