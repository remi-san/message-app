<?php
namespace MessageApp\Application\Response;

use Command\Response;
use MessageApp\ApplicationUser;

interface ApplicationResponse extends Response {

    /**
     * Returns the user the message must be sent to
     *
     * @return ApplicationUser
     */
    public function getUser();
}