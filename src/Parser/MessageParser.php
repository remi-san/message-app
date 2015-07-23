<?php
namespace MessageApp\Parser;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\MessageAppException;

interface MessageParser
{

    /**
     * Parse a message object to retrieve the matching command
     *
     * @param  object $object
     * @return NamedCommand
     * @throws MessageAppException
     */
    public function parse($object);
} 