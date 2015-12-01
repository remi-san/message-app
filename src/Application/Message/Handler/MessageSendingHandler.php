<?php
namespace MessageApp\Application\Message\Handler;

use MessageApp\Application\Message;
use MessageApp\Application\MessageSender;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class MessageSendingHandler implements MessageHandler, LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var MessageSender
     */
    protected $messageSender;

    /**
     * Constructor
     *
     * @param MessageSender $messageSender
     */
    public function __construct(MessageSender $messageSender)
    {
        $this->messageSender = $messageSender;
        $this->logger = new NullLogger();
    }

    /**
     * Handle a response
     *
     * @param  Message $message
     * @param  object  $context
     * @return void
     */
    public function handle(Message $message = null, $context = null)
    {
        if ($message === null) {
            return;
        }

        $this->logger->info('Sending message', array('message' => $message->getMessage()));
        $this->messageSender->send($message, $context);
    }

    /**
     * Sets a logger instance on the object
     *
     * @param  LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
