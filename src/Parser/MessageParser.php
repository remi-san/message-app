<?php

namespace MessageApp\Parser;

use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Parser\Exception\MessageParserException;

interface MessageParser
{
    /**
     * Parse a message to retrieve the matching command
     *
     * @param  mixed $message
     * @throws MessageParserException
     * @return NamedCommand
     */
    public function parse($message);
}
