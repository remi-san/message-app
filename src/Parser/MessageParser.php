<?php
namespace MessageApp\Parser;

use Command\Command;
use MessageApp\MessageAppException;

interface MessageParser
{

    /**
     * Parse a message object to retrieve the matching command
     *
     * @param  object $object
     * @return Command
     * @throws MessageAppException
     */
    public function parse($object);
} 