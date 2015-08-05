<?php
namespace MessageApp\Application\Handler;

use MessageApp\Application\Command\CreateUserCommand;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\User\ApplicationUserManager;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class MessageAppCommandHandler implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ApplicationUserManager
     */
    private $userManager;

    /**
     * Constructor
     *
     * @param ApplicationUserManager $userManager
     */
    public function __construct(ApplicationUserManager $userManager)
    {
        $this->userManager = $userManager;
        $this->logger = new NullLogger();
    }

    /**
     * Handles a CreateUserCommand
     *
     * @param  CreateUserCommand $command
     * @return string
     */
    public function handleCreateUserCommand(CreateUserCommand $command)
    {
        $user = $command->getUser();

        try {
            $this->userManager->save($user);
            $messageText = 'Welcome!';
        } catch (\Exception $e) {
            $messageText = 'Could not create the player!';
        }

        // TODO do not build response here - send event while saving
        return new SendMessageResponse($user, $messageText);
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
