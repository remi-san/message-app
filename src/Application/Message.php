<?php
namespace MessageApp\Application;

use MessageApp\ApplicationUser;

interface Message {

    /**
     * Returns the message
     *
     * @return string
     */
    public function getMessage();

    /**
     * Returns the user the message must be sent to
     *
     * @return \MessageApp\ApplicationUser
     */
    public function getUser();
} 