<?php
namespace MessageApp\User;

class UndefinedApplicationUser {

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
     * Gets the original User
     *
     * @return object
     */
    public function getOriginalUser()
    {
        return $this->originalUser;
    }
} 