<?php
namespace MessageApp\User;

interface ApplicationUser
{
    /**
     * Returns the id
     *
     * @return ApplicationUserId
     */
    public function getId();

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function getUncommittedEvents();
}
