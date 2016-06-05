<?php
namespace MessageApp\Test\Mock;

use Broadway\Domain\AggregateRoot;
use Broadway\Domain\DomainEventStream;
use MessageApp\Message;
use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;

class AggregateRootApplicationUser implements AggregateRoot, ApplicationUser
{
    /**
     * @return DomainEventStream
     */
    public function getUncommittedEvents()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return 0;
    }

    /**
     * Returns the id
     *
     * @return ApplicationUserId
     */
    public function getId()
    {
        return 0;
    }

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName()
    {
        return 'name';
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
}
