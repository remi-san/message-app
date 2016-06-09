<?php

namespace MessageApp;

use League\Tactician\CommandBus;
use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\MessageParser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class MessageApplication implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var MessageSender
     */
    protected $messageSender;

    /**
     * @var MessageParser
     */
    protected $messageParser;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * Constructor
     *
     * @param MessageSender  $messageSender
     * @param MessageParser  $messageParser
     * @param MessageFactory $messageFactory
     * @param CommandBus     $commandBus
     */
    public function __construct(
        MessageSender $messageSender,
        MessageParser $messageParser,
        MessageFactory $messageFactory,
        CommandBus $commandBus
    ) {
        $this->messageSender = $messageSender;
        $this->messageParser = $messageParser;
        $this->messageFactory = $messageFactory;
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
        $this->handleCommand($command);
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
            $this->logger->error('Error parsing or executing command', ['exception' => $e->getMessage()]);

            $errorMessage = $this->messageFactory->buildMessage([$e->getUser()], $e);

            if (!$errorMessage) {
                $this->logger->warning('Message could not be generated');
                return null;
            }

            $this->messageSender->send($errorMessage, $message);
            return null;
        }
    }

    /**
     * Handles the command
     *
     * @param NamedCommand $command
     */
    private function handleCommand(NamedCommand $command = null)
    {
        if ($command === null) {
            $this->logger->info('Message ignored');
            return;
        }

        $this->commandBus->handle($command);
    }
}
