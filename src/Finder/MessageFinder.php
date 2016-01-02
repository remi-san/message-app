<?php
namespace MessageApp\Finder;

use MessageApp\SourceMessage;

interface MessageFinder
{
    /**
     * Finds a message by reference
     *
     * @param  mixed $reference
     *
     * @return SourceMessage
     */
    public function findByReference($reference);
}
