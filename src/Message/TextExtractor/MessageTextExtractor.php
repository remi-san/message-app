<?php

namespace MessageApp\Message\TextExtractor;

interface MessageTextExtractor
{
    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @param  string $languageIso
     * @return string
     */
    public function extractMessage($object, $languageIso);
}
