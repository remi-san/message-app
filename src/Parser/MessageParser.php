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
     * @return NamedCommand
     * @throws MessageParserException
     */
    public function parse($message);
}
