<?php
namespace MessageApp\Handler;

use MessageApp\Command\CreateUserCommand;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\User\ApplicationUser;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\Repository\ApplicationUserRepository;
use MessageApp\User\UndefinedApplicationUser;
use MessageApp\User\ApplicationUserFactory;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use RemiSan\Command\ErrorEventHandler;

class MessageAppCommandHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var ApplicationUserFactory
     */
    private $userBuilder;

    /**
     * @var ApplicationUserRepository
     */
    private $userManager;

    /**
     * @var ErrorEventHandler
     */
    private $errorHandler;

    /**
     * Constructor
     *
     * @param ApplicationUserFactory    $userBuilder
     * @param ApplicationUserRepository $userManager
     * @param ErrorEventHandler         $errorHandler
     */
    public function __construct(
        ApplicationUserFactory $userBuilder,
        ApplicationUserRepository $userManager,
        ErrorEventHandler $errorHandler
    ) {
        $this->userBuilder = $userBuilder;
        $this->userManager = $userManager;
        $this->errorHandler = $errorHandler;
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
            $this->errorHandler->handle(
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
}
