<?php
namespace MessageApp\Listener;

use League\Event\EventInterface;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class UnableToCreateUserEventHandler implements MessageEventHandler, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var MessageSender
     */
    private $messageSender;

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
     * @param mixed          $context
     *
     * @return void
     */
    public function handle(EventInterface $event, $context = null)
    {
        if (! $event instanceof UnableToCreateUserEvent) {
            return;
        }

        $this->logger->info('Send message'); // TODO add better message

        $message = new DefaultMessage($event->getUser(), $event->getReason());
        $this->messageSender->send($message, $context);
    }
}
