<?php
namespace MessageApp\Test\Mock;

use MessageApp\Application\Message;
use MessageApp\Application\Response\ApplicationResponse;

class MessageResponse implements ApplicationResponse, Message
{
    public function getUser()
    {
        return null;
    }

    public function getMessage()
    {
        return null;
    }
}
