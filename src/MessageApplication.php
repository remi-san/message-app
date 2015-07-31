<?php
namespace MessageApp;

use League\Tactician\CommandBus;
use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\MessageParser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class MessageApplication implements LoggerAwareInterface
{
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
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * Constructor
     *
     * @param ApplicationResponseHandler $responseHandler
     * @param MessageParser              $messageParser
     * @param CommandBus                 $commandBus
     */
    public function __construct(
        ApplicationResponseHandler $responseHandler,
        MessageParser $messageParser,
        CommandBus $commandBus
    ) {
        $this->responseHandler = $responseHandler;
        $this->messageParser = $messageParser;
        $this->commandBus = $commandBus;
        $this->logger = new NullLogger();
    }

    /**
     * Handle a message
     *
     * @param  mixed $message
     * @return void
     */
    public function handle($message)
    {
        $this->logger->info($message);
        $command = $this->parseMessage($message);
        $this->handleCommand($command, $message);
    }

    /**
     * Parse the message
     *
     * @param  mixed $message
     * @return NamedCommand
     */
    private function parseMessage($message)
    {
        try {
            return $this->messageParser->parse($message);
        } catch (MessageParserException $e) {
            $this->logger->error('Error parsing or executing command', array('exception' => $e->getMessage()));
            $this->responseHandler->handle(
                new SendMessageResponse($e->getUser(), $e->getMessage()),
                $message
            );
            return null;
        }
    }

    /**
     * Handles the command
     *
     * @param NamedCommand $command
     * @param mixed        $message
     */
    private function handleCommand(NamedCommand $command = null, $message = null)
    {
        if ($command === null) {
            $this->logger->info('Message ignored');
            return;
        }

        // TODO no response should be returned
        $response = $this->commandBus->handle($command);

        // TODO handle after event dispatched
        $this->responseHandler->handle($response, $message);
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
