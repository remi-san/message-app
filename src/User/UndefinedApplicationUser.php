<?php

namespace MessageApp\User;

use MessageApp\Parser\LocalizedUser;

class UndefinedApplicationUser implements ApplicationUser, LocalizedUser
{
    /**
     * @var object
     */
    protected $originalUser;

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
     * Returns the id
     *
     * @return string|int
     */
    public function getId()
    {
        return null;
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return null;
    }

    /**
     * Returns the preferred language
     *
     * @return string
     */
    public function getPreferredLanguage()
    {
        return 'en';
    }

    /**
     * Gets the original User
     *
     * @return object
     */
    public function getOriginalUser()
    {
        return $this->originalUser;
    }

    /**
     * @inheritDoc
     */
    public function isDefined()
    {
        return false;
    }
}
