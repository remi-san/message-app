<?php
namespace MessageApp\Application\Handler;

use MessageApp\Application\Command\CreateUserCommand;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\ApplicationUser;
use MessageApp\User\ApplicationUserManager;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\UndefinedApplicationUser;
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
        $user = null;
        $originalUser = $command->getOriginalUser();

        try {
            $user = $this->createUser($originalUser);
            $this->userManager->save($user);
            $messageText = 'Welcome!';
        } catch (\Exception $e) {
            $user = new UndefinedApplicationUser($originalUser);
            $messageText = 'Could not create the user!';
        }

        // TODO do not build response here - send event while saving
        return new SendMessageResponse($user, $messageText);
    }

    /**
     * Creates the player
     *
     * @param  object $originalUser
     * @return ApplicationUser
     */
    private function createUser($originalUser)
    {
        $user = null;

        try {
            $this->logger->debug('Trying to create user');
            $user = $this->userManager->create($originalUser);
            $this->logger->info('User Created');
        } catch (AppUserException $e) {
            $this->logger->error('Error creating the user');
        }

        return $user;
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
