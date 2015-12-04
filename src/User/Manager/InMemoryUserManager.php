<?php
namespace MessageApp\User\Manager;

use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Exception\AppUserException;

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
     * @param  ApplicationUserId $id
     * @return ApplicationUser
     */
    public function get(ApplicationUserId $id)
    {
        return array_key_exists((string)$id, $this->users) ? $this->users[(string)$id] : null;
    }

    /**
     * Retrieves a player
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    abstract public function getByObject($object);

    /**
     * Creates an application user
     *
     * @param  object $object
     * @return ApplicationUser
     * @throws AppUserException
     */
    abstract public function create($object);

    /**
     * Saves a user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function save(ApplicationUser $user)
    {
        $this->users[(string)$user->getId()] = $user;
    }
}
