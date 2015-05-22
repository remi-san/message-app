<?php
namespace MessageApp\Parser;

use MessageApp\Application\Command\ApplicationCommand;
use MessageApp\Parser\Exception\MessageParserException;

interface MessageParser {

    /**
     * Parse a message object to retrieve the matching command
     *
     * @param  object $object
     * @return ApplicationCommand
     * @throws MessageParserException
     */
    public function parse($object);
} 