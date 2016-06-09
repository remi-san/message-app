<?php

namespace MessageApp\Listener;

use League\Event\EventInterface;
use MessageApp\Event\UserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\User\Finder\AppUserFinder;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use RemiSan\Context\Context;

class UserEventHandler implements MessageEventHandler, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var AppUserFinder
     */
    private $userFinder;

    /**
     * @var MessageFinder
     */
    private $messageFinder;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * Constructor
     *
     * @param AppUserFinder $userFinder
     * @param MessageFinder $messageFinder
     * @param MessageFactory $messageFactory
     * @param MessageSender $messageSender
     */
    public function __construct(
        AppUserFinder $userFinder,
        MessageFinder $messageFinder,
        MessageFactory $messageFactory,
        MessageSender $messageSender
    ) {
        $this->userFinder = $userFinder;
        $this->messageFinder = $messageFinder;
        $this->messageFactory = $messageFactory;
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
        if (! ($event instanceof UserEvent && $event->getUserId() && $event->getAsMessage())) {
            return;
        }

        // Build message
        $user = $this->userFinder->find($event->getUserId());

        $this->logger->info(
            'Send message',
            [
                'user' => $user->getName(),
                'message' => $event->getAsMessage(),
                'type' => $event->getName()
            ]
        );

        $messageContext = null;
        if ($context) {
            $messageContext = $this->messageFinder->findByReference($context->getValue());
        }

        $message = $this->messageFactory->buildMessage([$user], $event);

        if (!$message) {
            $this->logger->warning('Message could not be generated');
            return;
        }

        $this->messageSender->send($message, ($messageContext) ? $messageContext->getSource() : null);
    }
}
