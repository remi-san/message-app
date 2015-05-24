<?php
namespace MessageApp\Parser;

use MessageApp\Application\Command\ApplicationCommand;
use MessageApp\MessageAppException;

interface MessageParser {

    /**
     * Parse a message object to retrieve the matching command
     *
     * @param  object $object
     * @return ApplicationCommand
     * @throws MessageAppException
     */
    public function parse($object);
} 