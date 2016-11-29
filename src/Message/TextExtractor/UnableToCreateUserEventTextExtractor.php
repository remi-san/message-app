<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Event\UnableToCreateUserEvent;
use RemiSan\Intl\TranslatableResource;

class UnableToCreateUserEventTextExtractor implements MessageTextExtractor
{
    const MESSAGE_KEY = 'user.created.failed';

    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @return TranslatableResource
     */
    public function extractMessage($object)
    {
        if (!$object instanceof UnableToCreateUserEvent) {
            return null;
        }

        return new TranslatableResource(self::MESSAGE_KEY);
    }
}
