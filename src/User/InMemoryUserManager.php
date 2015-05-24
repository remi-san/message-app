<?php
namespace MessageApp\User;

use MessageApp\ApplicationUser;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Exception\UnsupportedUserException;

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
     * @throws AppUserException
     */
    public function getUser($object)
    {
        if (!$this->supports($object)) {
            throw new UnsupportedUserException(new UndefinedApplicationUser($object));
        }

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
     * @throws AppUserException
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

    /**
     * Can the user manager deal with that object?
     *
     * @param  object $object
     * @return boolean
     */
    protected abstract function supports($object);
}