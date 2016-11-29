<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Event\UserCreatedEvent;
use RemiSan\Intl\TranslatableResource;

class UserCreatedEventTextExtractor implements MessageTextExtractor
{
    const MESSAGE_KEY = 'user.created';

    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @return TranslatableResource
     */
    public function extractMessage($object)
    {
        if (!$object instanceof UserCreatedEvent) {
            return null;
        }

        return new TranslatableResource(self::MESSAGE_KEY);
    }
}
