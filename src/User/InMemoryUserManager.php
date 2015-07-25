<?php
namespace MessageApp\User;

use MessageApp\ApplicationUser;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Exception\UnsupportedUserException;

abstract class InMemoryUserManager implements ApplicationUserManager
{
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
     * Retrieves an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function get($object)
    {
        if (!$this->supports($object)) {
            throw new UnsupportedUserException(new UndefinedApplicationUser($object));
        }

        $userId = $this->getUserId($object);
        if (!array_key_exists($userId, $this->users)) {
            $this->save($this->create($object));
        }
        return $this->users[$userId];
    }

    /**
     * Can the user manager deal with that object?
     *
     * @param  object $object
     * @return boolean
     */
    abstract protected function supports($object);

    /**
     * Gets the user id from the user object
     *
     * @param  object $object
     * @return string
     */
    abstract protected function getUserId($object);

    /**
     * Saves a user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function save(ApplicationUser $user)
    {
        $this->users[$user->getId()] = $user;
    }

    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    abstract public function create($object);
}
