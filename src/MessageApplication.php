<?php
namespace MessageApp;

use MessageApp\Application\Command\ApplicationCommand;
use MessageApp\Application\CommandExecutor;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\MessageParser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

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
     * An array of player ids to ignore
     *
     * @var int[]
     */
    protected $ignoreUsers;


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
        $this->ignoreUsers = array();
    }

    /**
     * Sets the list of player ids to ignore
     *
     * @param  int[] $ids
     * @return void
     */
    public function setUsersToIgnore(array $ids)
    {
        $this->ignoreUsers = $ids;
    }

    /**
     * Handle a message object
     *
     * @param  object $object
     * @return void
     */
    protected function handleMessage($object)
    {
        if ($this->logger) {
            $this->logger->info($object);
        }

        $response = null;
        try {
            $command = $this->messageParser->parse($object);
            if ($this->isCommandIgnored($command)) {
                $this->logger->info('Message ignored');
                return null;
            }
            $response = $this->executor->execute($command);
        } catch (MessageParserException $e) {
            // TODO add an error handler?
            $response = new SendMessageResponse($e->getUser(), $e->getMessage());
        }

        $this->responseHandler->handle($response, $object);
    }

    /**
     * Must we ignore the command?
     *
     * @param  ApplicationCommand $command
     * @return bool
     */
    protected function isCommandIgnored(ApplicationCommand $command = null) {
        return (!$command || in_array($command->getUser()->getId(), $this->ignoreUsers));
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