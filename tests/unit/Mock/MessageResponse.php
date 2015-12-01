<?php
namespace MessageApp\Test\Mock;

use MessageApp\Application\Message;

class MessageResponse implements Message
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
