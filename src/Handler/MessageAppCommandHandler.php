<?php

namespace MessageApp\Handler;

use MessageApp\Command\CreateUserCommand;
use MessageApp\Error\ErrorEventHandler;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\User\ApplicationUser;
use MessageApp\User\UserFactory;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Repository\UserRepository;
use MessageApp\User\UndefinedApplicationUser;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use RemiSan\Context\ContextContainer;

class MessageAppCommandHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var UserFactory
     */
    private $userBuilder;

    /**
     * @var UserRepository
     */
    private $userManager;

    /**
     * @var ErrorEventHandler
     */
    private $errorHandler;

    /**
     * Constructor
     *
     * @param UserFactory       $userBuilder
     * @param UserRepository    $userManager
     * @param ErrorEventHandler $errorHandler
     */
    public function __construct(
        UserFactory $userBuilder,
        UserRepository $userManager,
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

        ContextContainer::setContext($command->getContext());

        try {
            $user = $this->createUser(
                $command->getId(),
                $originalUser,
                $command->getPreferredLanguage()
            );
            $this->userManager->save($user);
            $this->logger->info('User Created');
        } catch (\Exception $e) {
            $this->logger->error('Error creating the user');
            $this->errorHandler->handle(
                new UnableToCreateUserEvent(
                    $command->getId(),
                    new UndefinedApplicationUser($originalUser)
                )
            );
        }

        ContextContainer::reset();
    }

    /**
     * Creates the player
     *
     * @param ApplicationUserId $userId
     * @param  object           $originalUser
     * @param  string           $language
     *
     * @return SourcedUser
     */
    private function createUser(ApplicationUserId $userId, $originalUser, $language)
    {
        $this->logger->debug('Trying to create user');
        return $this->userBuilder->create($userId, $originalUser, $language);
    }
}
