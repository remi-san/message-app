<?php

namespace MessageApp\Command;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use RemiSan\Context\Context;
use RemiSan\Context\ContextAware;

class CreateUserCommand implements NamedCommand, ContextAware
{
    const NAME = 'USER.CREATE';

    /**
     * @var object
     */
    private $originalUser;

    /**
     * @var string
     */
    private $preferredLanguage;

    /**
     * @var Context
     */
    private $context;

    /**
     * Constructor.
     */
    public function __construct()
    {
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
     * @return string
     */
    public function getPreferredLanguage()
    {
        return $this->preferredLanguage;
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

    /**
     * Static constructor.
     *
     * @param object  $originalUser
     * @param string  $preferredLanguage
     * @param Context $context
     *
     * @return CreateUserCommand
     */
    public static function create($originalUser, $preferredLanguage, Context $context = null)
    {
        $obj = new self();

        $obj->originalUser = $originalUser;
        $obj->preferredLanguage = $preferredLanguage;
        $obj->context = $context;

        return $obj;
    }
}
