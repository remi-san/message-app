<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Event\UnableToCreateUserEvent;

class UnableToCreateUserEventTextExtractor implements MessageTextExtractor
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
        if (!$object instanceof UnableToCreateUserEvent) {
            return null;
        }

        return $object->getReason();
    }
}
