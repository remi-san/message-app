<?php
namespace MessageApp;

use League\Tactician\CommandBus;
use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Application\Message\DefaultMessage;
use MessageApp\Application\MessageSender;
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
     * @var MessageSender
     */
    protected $messageSender;

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
     * @param MessageSender  $messageSender
     * @param MessageParser  $messageParser
     * @param CommandBus     $commandBus
     */
    public function __construct(
        MessageSender $messageSender,
        MessageParser $messageParser,
        CommandBus $commandBus
    ) {
        $this->messageSender = $messageSender;
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
            $this->messageSender->send(
                new DefaultMessage($e->getUser(), $e->getMessage()),
                $message
            );
            return null;
        }
    }

    /**
     * Handles the command
     *
     * @param NamedCommand $command
     * @param mixed        $originalMessage
     */
    private function handleCommand(NamedCommand $command = null, $originalMessage = null)
    {
        if ($command === null) {
            $this->logger->info('Message ignored');
            return;
        }

        // TODO no response should be returned
        $returnMessage = $this->commandBus->handle($command);

        // TODO handle after event dispatched
        $this->messageSender->send($returnMessage, $originalMessage);
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
