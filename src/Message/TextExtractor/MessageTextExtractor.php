<?php

namespace MessageApp\Message\TextExtractor;

use RemiSan\Intl\TranslatableResource;

interface MessageTextExtractor
{
    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @return TranslatableResource
     */
    public function extractMessage($object);
}
