<?php
namespace MessageApp\Application\Response;

use MessageApp\ApplicationUser;

interface ApplicationResponse {

    /**
     * Returns the user the message must be sent to
     *
     * @return ApplicationUser
     */
    public function getUser();
}