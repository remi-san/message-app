<?php

namespace MessageApp\Message\TextExtractor;

use RemiSan\Intl\TranslatableResource;

class CompositeTextExtractor implements MessageTextExtractor
{
    /**
     * @var MessageTextExtractor[]
     */
    private $extractors;

    /**
     * Constructor.
     *
     * @param array $extractors
     */
    public function __construct(array $extractors = [])
    {
        $this->extractors = $extractors;
    }

    /**
     * @param MessageTextExtractor $extractor
     */
    public function addExtractor(MessageTextExtractor $extractor)
    {
        $this->extractors[] = $extractor;
    }

    /**
     * Extract the message from the game result.
     *
     * @param  object $object
     * @return TranslatableResource
     */
    public function extractMessage($object)
    {
        foreach ($this->extractors as $extractor) {
            if ($message = $extractor->extractMessage($object)) {
                return $message;
            }
        }

        return null;
    }
}
