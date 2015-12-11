<?php
namespace MessageApp\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;
use MessageApp\Event\UserEvent;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\User\Finder\AppUserFinder;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class UserEventListener extends AbstractListener implements LoggerAwareInterface
{
    /**
     * @var AppUserFinder
     */
    private $userFinder;

    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     *
     * @param AppUserFinder $userFinder
     * @param MessageSender $messageSender
     */
    public function __construct(AppUserFinder $userFinder, MessageSender $messageSender)
    {
        $this->userFinder = $userFinder;
        $this->messageSender = $messageSender;
        $this->logger = new NullLogger();
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        if (! $event instanceof UserEvent) {
            return;
        }

        if (!$event->getUserId() || !$event->getAsMessage()) {
            return;
        }

        $this->logger->info('Send message'); // TODO add better message

        // TODO retrieve the original message
        $originalMessage = null;

        // Build message
        $user = $this->userFinder->find($event->getUserId());
        $message = new DefaultMessage($user, $event->getAsMessage());
        $this->messageSender->send($message, $originalMessage);
    }

    /**
     * Sets a logger instance on the object
     *
     * @param LoggerInterface $logger
     * @return null
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
