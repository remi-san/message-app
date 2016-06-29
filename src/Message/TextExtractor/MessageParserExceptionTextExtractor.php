<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Parser\Exception\MessageParserException;
use RemiSan\Intl\TranslatableResource;

class MessageParserExceptionTextExtractor implements MessageTextExtractor
{
    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @return TranslatableResource
     */
    public function extractMessage($object)
    {
        if (!$object instanceof MessageParserException) {
            return null;
        }

        return new TranslatableResource($object->getCodeName());
    }
}
