<?php
namespace MessageApp\Application\Response;

use MessageApp\ApplicationUser;

class HandshakeResponse implements ApplicationResponse {

    /**
     * @var ApplicationUser
     */
    protected $user;

    /**
     * Construct
     *
     * @param ApplicationUser $user
     */
    public function __construct(ApplicationUser $user) {
        $this->user = $user;
    }

    /**
     * Returns the user the message must be sent to
     *
     * @return ApplicationUser
     */
    public function getUser() {
        return $this->user;
    }
} 