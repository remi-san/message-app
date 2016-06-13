<?php

namespace MessageApp\Message\TextExtractor;

use MessageApp\Event\UserEvent;
use RemiSan\Intl\TranslatableResource;

class UserEventTextExtractor implements MessageTextExtractor
{
    /**
     * @var MessageTextExtractor[]
     */
    private $gameResultExtractors;

    /**
     * Constructor.
     *
     * @param $gameResultExtractors
     */
    public function __construct(array $gameResultExtractors = [])
    {
        $this->gameResultExtractors = $gameResultExtractors;
    }

    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @param  string $languageIso
     * @return TranslatableResource
     */
    public function extractMessage($object, $languageIso)
    {
        if (!$object instanceof UserEvent) {
            return null;
        }

        foreach ($this->gameResultExtractors as $extractor) {
            if ($message = $extractor->extractMessage($object, $languageIso)) {
                return $message;
            }
        }

        throw new \InvalidArgumentException('Unsupported User Event');
    }
}
