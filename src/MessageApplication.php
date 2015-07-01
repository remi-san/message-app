<?php
namespace MessageApp;

use Command\CommandExecutor;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\Parser\MessageParser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class MessageApplication implements LoggerAwareInterface {

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ApplicationResponseHandler
     */
    protected $responseHandler;

    /**
     * @var MessageParser
     */
    protected $messageParser;

    /**
     * @var CommandExecutor
     */
    protected $executor;


    /**
     * Constructor
     *
     * @param ApplicationResponseHandler $responseHandler
     * @param MessageParser              $messageParser
     * @param CommandExecutor            $executor
     */
    public function __construct(ApplicationResponseHandler $responseHandler, MessageParser $messageParser, CommandExecutor $executor) {
        $this->responseHandler = $responseHandler;
        $this->messageParser = $messageParser;
        $this->executor = $executor;
        $this->logger = new NullLogger();
    }

    /**
     * Handle a message object
     *
     * @param  object $object
     * @return void
     */
    protected function handleMessage($object)
    {
        $this->logger->info($object);

        $response = null;
        try {
            $command = $this->messageParser->parse($object);
            if ($command === null) {
                $this->logger->info('Message ignored');
                return;
            }
            $response = $this->executor->execute($command);
        } catch (MessageAppException $e) {
            $this->logger->error('Error parsing or executing command', array('exception' => $e->getMessage()));
            $response = new SendMessageResponse($e->getUser(), $e->getMessage());
        }

        $this->responseHandler->handle($response, $object);
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