<?php

namespace MessageApp\User;

class UndefinedApplicationUser implements ApplicationUser
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
     * Gets the original User
     *
     * @return object
     */
    public function getOriginalUser()
    {
        return $this->originalUser;
    }
}
