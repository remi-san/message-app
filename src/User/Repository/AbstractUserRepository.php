<?php
namespace MessageApp\User\Repository;

use League\Event\EmitterInterface;
use League\Event\EventInterface;
use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Store\ApplicationUserStore;

abstract class AbstractUserRepository implements ApplicationUserRepository
{
    /**
     * @var ApplicationUserStore
     */
    protected $userRepository;

    /**
     * @var EmitterInterface
     */
    private $eventEmitter;

    /**
     * Constructor
     *
     * @param ApplicationUserStore $userRepository
     * @param EmitterInterface  $eventEmitter
     */
    public function __construct(
        ApplicationUserStore $userRepository,
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
            $this->eventEmitter->emit($this->prepareEvent($domainMessage));
        }
    }

    /**
     * Prepares the event to return a League Event
     *
     * @param  mixed $originalEvent
     * @return EventInterface
     */
    abstract protected function prepareEvent($originalEvent);
}