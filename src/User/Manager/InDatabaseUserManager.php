<?php
namespace MessageApp\User\Manager;

use Broadway\Domain\DomainMessage;
use League\Event\EmitterInterface;
use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Repository\AppUserRepository;

abstract class InDatabaseUserManager implements ApplicationUserManager
{
    /**
     * @var AppUserRepository
     */
    protected $userRepository;

    /**
     * @var EmitterInterface
     */
    private $eventEmitter;

    /**
     * Constructor
     *
     * @param AppUserRepository $userRepository
     * @param EmitterInterface  $eventEmitter
     */
    public function __construct(
        AppUserRepository $userRepository,
        EmitterInterface $eventEmitter
    ) {
        $this->userRepository = $userRepository;
        $this->eventEmitter = $eventEmitter;
    }

    /**
     * Retrieves an application user
     *
     * @param  ApplicationUserId $id
     * @return ApplicationUser
     * @throws AppUserException
     */
    public function get(ApplicationUserId $id)
    {
        return $this->userRepository->find($id);
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
        $this->userRepository->save($user);

        $eventStream = $user->getUncommittedEvents();
        foreach ($eventStream as $domainMessage) {
            /* @var $domainMessage DomainMessage */
            $this->eventEmitter->emit($domainMessage->getPayload());
        }
    }
}
