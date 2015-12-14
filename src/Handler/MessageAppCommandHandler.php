<?php
namespace MessageApp\Handler;

use League\Event\EmitterInterface;
use MessageApp\Command\CreateUserCommand;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\User\ApplicationUser;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Repository\ApplicationUserRepository;
use MessageApp\User\UndefinedApplicationUser;
use MessageApp\User\UserBuilder;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class MessageAppCommandHandler implements LoggerAwareInterface
{
    /**
     * @var UserBuilder
     */
    private $userBuilder;

    /**
     * @var ApplicationUserRepository
     */
    private $userManager;

    /**
     * @var EmitterInterface
     */
    private $eventEmitter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor
     *
     * @param UserBuilder            $userBuilder
     * @param \MessageApp\User\Repository\ApplicationUserRepository $userManager
     * @param EmitterInterface       $eventEmitter
     */
    public function __construct(
        UserBuilder $userBuilder,
        ApplicationUserRepository $userManager,
        EmitterInterface $eventEmitter
    ) {
        $this->userBuilder = $userBuilder;
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
            $user = $this->userBuilder->create($originalUser);
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
