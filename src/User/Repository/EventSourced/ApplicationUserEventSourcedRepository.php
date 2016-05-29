<?php

namespace MessageApp\User\Repository\EventSourced;

use Broadway\Domain\AggregateRoot;
use Broadway\EventSourcing\EventSourcingRepository;
use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Repository\ApplicationUserRepository;

class ApplicationUserEventSourcedRepository implements ApplicationUserRepository
{
    /**
     * @var EventSourcingRepository
     */
    private $repository;

    /**
     * Constructor
     *
     * @param EventSourcingRepository $repository
     */
    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Saves a mini-game
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function save(ApplicationUser $user)
    {
        if (!$user instanceof AggregateRoot) {
            throw new \InvalidArgumentException();
        }

        $this->repository->save($user);
    }

    /**
     * Get the user corresponding to the id
     *
     * @param  ApplicationUserId $id
     * @throws AppUserException
     * @return ApplicationUser
     */
    public function load(ApplicationUserId $id)
    {
        $user = $this->repository->load($id);

        if ($user !== null && ! $user instanceof ApplicationUser) {
            throw new \InvalidArgumentException();
        }

        return $user;
    }
}
