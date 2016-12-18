<?php

namespace MessageApp\User\Repository\EventSourced;

use Broadway\EventSourcing\EventSourcingRepository;
use MessageApp\Exception\MessageAppException;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Repository\UserRepository;

class UserEventSourcedRepository implements UserRepository
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
     * @param  SourcedUser $user
     *
     * @return void
     */
    public function save(SourcedUser $user)
    {
        $this->repository->save($user);
    }

    /**
     * Get the user corresponding to the id
     *
     * @param  ApplicationUserId $id
     *
     * @throws MessageAppException
     * @return SourcedUser
     */
    public function load(ApplicationUserId $id)
    {
        $user = $this->repository->load($id);

        if ($user !== null && ! $user instanceof SourcedUser) {
            throw new \InvalidArgumentException();
        }

        return $user;
    }
}
