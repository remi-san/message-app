<?php
namespace MessageApp\Test\Mock;

use MessageApp\Message;

class MessageResponse implements Message
{
    public function getUsers()
    {
        return [];
    }

    public function getMessage()
    {
        return null;
    }
}
