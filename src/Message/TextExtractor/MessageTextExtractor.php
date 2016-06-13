<?php

namespace MessageApp\Message\TextExtractor;

use RemiSan\Intl\TranslatableResource;

interface MessageTextExtractor
{
    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @param  string $languageIso
     * @return TranslatableResource
     */
    public function extractMessage($object, $languageIso);
}
