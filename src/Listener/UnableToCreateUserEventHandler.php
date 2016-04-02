<?php

namespace MessageApp\Listener;

use League\Event\EventInterface;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use RemiSan\Context\Context;

class UnableToCreateUserEventHandler implements MessageEventHandler, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var MessageFinder
     */
    private $messageFinder;

    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * Constructor
     *
     * @param MessageFinder $messageFinder
     * @param MessageSender $messageSender
     */
    public function __construct(
        MessageFinder $messageFinder,
        MessageSender $messageSender
    ) {
        $this->messageFinder = $messageFinder;
        $this->messageSender = $messageSender;
        $this->logger = new NullLogger();
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     * @param Context        $context
     *
     * @return void
     */
    public function handle(EventInterface $event, Context $context = null)
    {
        if (! $event instanceof UnableToCreateUserEvent) {
            return;
        }

        $this->logger->info(
            'Send message',
            [
                'user' => $event->getUser()->getName(),
                'message' => $event->getReason(),
                'type' => $event->getName()
            ]
        );

        $messageContext = null;
        if ($context) {
            $messageContext = $this->messageFinder->findByReference($context->getValue());
        }

        $message = new DefaultMessage($event->getUser(), $event->getReason());
        $this->messageSender->send($message, ($messageContext)?$messageContext->getSource():null);
    }
}
