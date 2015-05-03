<?php
namespace MessageApp\Application\Command;

use MessageApp\ApplicationUser;

class AbstractApplicationCommand implements ApplicationCommand {

    /**
     * @var ApplicationUser
     */
    protected $user;

    /**
     * @param ApplicationUser $user
     */
    public function __construct(ApplicationUser $user)
    {
        $this->user = $user;
    }

    /**
     * @return ApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }
} 