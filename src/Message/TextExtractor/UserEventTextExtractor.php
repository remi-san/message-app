<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Event\UserEvent;

class UserEventTextExtractor implements MessageTextExtractor
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
        if (!$object instanceof UserEvent) {
            return null;
        }

        return $object->getAsMessage();
    }
}
