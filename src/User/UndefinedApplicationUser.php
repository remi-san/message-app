<?php

namespace MessageApp\User;

use MessageApp\Parser\ParsingUser;

class UndefinedApplicationUser implements ApplicationUser, ParsingUser
{
    /**
     * @var ApplicationUserId
     */
    protected $userId;

    /**
     * @var object
     */
    protected $originalUser;

    /**
     * Constructor
     *
     * @param ApplicationUserId $userId
     * @param object            $originalUser
     */
    public function __construct(
        ApplicationUserId $userId,
        $originalUser
    ) {
        $this->originalUser = $originalUser;
        $this->userId = $userId;
    }

    /**
     * Returns the id
     *
     * @return ApplicationUserId
     */
    public function getId()
    {
        return $this->userId;
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
