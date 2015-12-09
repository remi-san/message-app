<?php
namespace MessageApp\Listener;

use League\Event\AbstractListener;
use League\Event\EventInterface;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class UnableToCreateUserEventListener extends AbstractListener implements LoggerAwareInterface
{
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
     * @param MessageSender     $messageSender
     */
    public function __construct(MessageSender $messageSender)
    {
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
        if (! $event instanceof UnableToCreateUserEvent) {
            return;
        }

        $this->logger->info('Send message'); // TODO add better message

        // TODO retrieve the original message
        $originalMessage = null;

        $message = new DefaultMessage($event->getUser(), $event->getReason());
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
