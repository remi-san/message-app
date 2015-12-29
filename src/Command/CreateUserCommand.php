<?php
namespace MessageApp\Command;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use RemiSan\Command\Context;
use RemiSan\Command\ContextAwareCommand;

class CreateUserCommand implements NamedCommand, ContextAwareCommand
{
    const NAME = 'USER.CREATE';

    /**
     * @var object
     */
    private $originalUser;

    /**
     * @var Context
     */
    private $context;

    /**
     * Constructor
     *
     * @param object  $originalUser
     * @param Context $context
     */
    public function __construct($originalUser, Context $context = null)
    {
        $this->originalUser = $originalUser;
        $this->context = $context;
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
     * Returns the context
     *
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }
}
