<?php
namespace MessageApp\User;

use MessageApp\ApplicationUser;
use TwitterMessageApp\TwitterApplicationUser;

abstract class InMemoryUserManager implements ApplicationUserManager {

    /**
     * @var ApplicationUser[]
     */
    protected $users;

    /**
     * Constructor
     *
     * @param ApplicationUser[] $users
     */
    public function __construct(array $users = array())
    {
        $this->users = $users;
    }

    /**
     * Gets the user id from the user object
     *
     * @param  object $object
     * @return string
     */
    protected abstract function getUserId($object);

    /**
     * Retrieves an application user
     *
     * @param  object $object
     * @return ApplicationUser
     */
    public function getUser($object)
    {
        $userId = $this->getUserId($object);
        if (!array_key_exists($userId, $this->users)) {
            $this->saveUser($this->createUser($object));
        }
        return $this->users[$userId];
    }

    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
     */
    public abstract function createUser($object);

    /**
     * Saves a user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function saveUser(ApplicationUser $user)
    {
        $this->users[$user->getId()] = $user;
    }
}