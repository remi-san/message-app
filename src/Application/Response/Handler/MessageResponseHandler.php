<?php
namespace MessageApp\Application\Response\Handler;

use MessageApp\Application\Message;
use MessageApp\Application\MessageSender;
use MessageApp\Application\Response\ApplicationResponse;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class MessageResponseHandler implements ApplicationResponseHandler, LoggerAwareInterface
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
     * @param  ApplicationResponse $response
     * @param  object              $context
     * @return void
     */
    public function handle(ApplicationResponse $response = null, $context = null)
    {
        if (!$response || !($response instanceof Message)) {
            if ($this->logger) {
                $this->logger->info('Cannot handle response!');
            }
            return;
        }

        $this->logger->info('Sending message', array('message' => $response->getMessage()));
        $this->messageSender->send($response, $context);
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