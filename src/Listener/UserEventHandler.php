<?php
namespace MessageApp\Listener;

use League\Event\EventInterface;
use MessageApp\Event\UserEvent;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\User\Finder\AppUserFinder;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class UserEventHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var AppUserFinder
     */
    private $userFinder;

    /**
     * @var MessageSender
     */
    private $messageSender;

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
     * @param mixed          $context
     *
     * @return void
     */
    public function handle(EventInterface $event, $context = null)
    {
        if (! $event instanceof UserEvent) {
            return;
        }

        if (!$event->getUserId() || !$event->getAsMessage()) {
            return;
        }

        $this->logger->info('Send message'); // TODO add better message

        // Build message
        $user = $this->userFinder->find($event->getUserId());
        $message = new DefaultMessage($user, $event->getAsMessage());
        $this->messageSender->send($message, $context);
    }
}
