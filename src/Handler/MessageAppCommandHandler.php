<?php
namespace MessageApp\Handler;

use League\Event\EmitterInterface;
use MessageApp\Command\CreateUserCommand;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\User\ApplicationUser;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Manager\ApplicationUserManager;
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
     * @var EmitterInterface
     */
    private $eventEmitter;

    /**
     * Constructor
     *
     * @param ApplicationUserManager $userManager
     * @param EmitterInterface       $eventEmitter
     */
    public function __construct(
        ApplicationUserManager $userManager,
        EmitterInterface $eventEmitter
    ) {
        $this->userManager = $userManager;
        $this->eventEmitter = $eventEmitter;
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
        } catch (\Exception $e) {
            $this->eventEmitter->emit(
                new UnableToCreateUserEvent(
                    new UndefinedApplicationUser($originalUser),
                    'Could not create the user!'
                )
            );
        }
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
