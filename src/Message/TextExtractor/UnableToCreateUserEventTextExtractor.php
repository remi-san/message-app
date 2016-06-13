<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Event\UnableToCreateUserEvent;
use RemiSan\Intl\TranslatableResource;

class UnableToCreateUserEventTextExtractor implements MessageTextExtractor
{
    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @param  string $languageIso
     * @return TranslatableResource
     */
    public function extractMessage($object, $languageIso)
    {
        if (!$object instanceof UnableToCreateUserEvent) {
            return null;
        }

        return new TranslatableResource('Could not create the user!'); // TODO pass a key
    }
}
