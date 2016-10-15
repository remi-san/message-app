<?php

namespace MessageApp\Handler;

use MessageApp\Command\CreateUserCommand;
use MessageApp\Error\ErrorEventHandler;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Repository\UserRepository;
use MessageApp\User\ThirdParty\AccountFactory;
use MessageApp\User\UndefinedApplicationUser;
use MessageApp\User\UserFactory;
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
     * @var \MessageApp\User\ThirdParty\AccountFactory
     */
    private $accountFactory;

    /**
     * @var ErrorEventHandler
     */
    private $errorHandler;

    /**
     * Constructor
     *
     * @param UserFactory                                $userBuilder
     * @param UserRepository                             $userManager
     * @param \MessageApp\User\ThirdParty\AccountFactory $accountFactory
     * @param ErrorEventHandler                          $errorHandler
     */
    public function __construct(
        UserFactory $userBuilder,
        UserRepository $userManager,
        AccountFactory $accountFactory,
        ErrorEventHandler $errorHandler
    ) {
        $this->userBuilder = $userBuilder;
        $this->userManager = $userManager;
        $this->accountFactory = $accountFactory;
        $this->errorHandler = $errorHandler;
        $this->logger = new NullLogger();
    }

    /**
     * Handles a CreateUserCommand
     *
     * @param  CreateUserCommand $command
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
                    new UndefinedApplicationUser(
                        $this->accountFactory->build($originalUser)
                    )
                ),
                $command->getContext()
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
