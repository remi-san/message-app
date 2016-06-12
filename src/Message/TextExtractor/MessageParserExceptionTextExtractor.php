<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Parser\Exception\MessageParserException;

class MessageParserExceptionTextExtractor implements MessageTextExtractor
{
    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @param  string $languageIso
     * @return string
     */
    public function extractMessage($object, $languageIso)
    {
        if (!$object instanceof MessageParserException) {
            return null;
        }

        return $object->getMessage(); // TODO get the code and translate
    }
}
