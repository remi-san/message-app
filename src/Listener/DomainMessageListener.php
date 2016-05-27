<?php

namespace MessageApp\Listener;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListenerInterface;
use Broadway\Tools\Metadata\Context\ContextEnricher;

class DomainMessageListener implements EventListenerInterface
{
    /**
     * @var MessageEventHandler
     */
    private $handler;

    /**
     * Constructor
     *
     * @param MessageEventHandler $handler
     */
    public function __construct(MessageEventHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Handle an event.
     *
     * @param DomainMessage $message
     *
     * @return void
     */
    public function handle(DomainMessage $message)
    {
        $event = $message->getPayload();
        $context = static::getContext($message);

        $this->handler->handle($event, $context);
    }

    /**
     * @param  DomainMessage $message
     *
     * @return mixed
     */
    private static function getContext(DomainMessage $message)
    {
        $metadataArray = $message->getMetadata()->serialize();
        $context = isset($metadataArray[ContextEnricher::CONTEXT]) ? $metadataArray[ContextEnricher::CONTEXT] : null;

        return $context;
    }
}
