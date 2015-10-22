<?php
namespace MessageApp\User\Repository;

use MessageApp\ApplicationUser;
use MessageApp\ApplicationUserId;

interface AppUserRepository
{
    /**
     * Finds an user by its primary key / identifier.
     *
     * @param  string $id The identifier.
     *
     * @return ApplicationUser The user.
     */
    public function find($id);

    /**
     * Finds all users in the repository.
     *
     * @return ApplicationUser[] The users.
     */
    public function findAll();

    /**
     * Finds users by a set of criteria.
     *
     * Optionally sorting and limiting details can be passed. An implementation may throw
     * an UnexpectedValueException if certain values of the sorting or limiting details are
     * not supported.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return ApplicationUser[] The users.
     *
     * @throws \UnexpectedValueException
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * Finds a single user by a set of criteria.
     *
     * @param array $criteria The criteria.
     *
     * @return ApplicationUser The user.
     */
    public function findOneBy(array $criteria);

    /**
     * Saves a mini game
     *
     * @param  ApplicationUser $game
     *
     * @return void
     */
    public function save(ApplicationUser $game);

    /**
     * Deletes a mini game
     *
     * @param  ApplicationUser $game
     *
     * @return void
     */
    public function delete(ApplicationUser $game);
}
