<?php

namespace MessageApp\Listener;

use League\Event\ListenerInterface;
use MessageApp\Event\ThirdPartyAccountLinkedEvent;
use MessageApp\Event\ThirdPartyAccountReplacedEvent;
use MessageApp\Event\UserCreatedEvent;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Finder\AppUserFinder;
use MessageApp\User\ThirdParty\Account;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class ApplicationUserListener implements ListenerInterface, LoggerAwareInterface
{
    use ListenerTrait, LoggerAwareTrait;

    /**
     * @var ApplicationUserFactory
     */
    private $appUserFactory;

    /**
     * @var AppUserFinder
     */
    private $finder;

    /**
     * Constructor
     *
     * @param ApplicationUserFactory $appUserFactory
     * @param AppUserFinder          $finder
     */
    public function __construct(
        ApplicationUserFactory $appUserFactory,
        AppUserFinder $finder
    ) {
        $this->appUserFactory = $appUserFactory;
        $this->finder = $finder;
        $this->logger = new NullLogger();
    }

    /**
     * @param UserCreatedEvent $event
     */
    public function handleUserCreatedEvent(UserCreatedEvent $event)
    {
        $this->logger->info('Message read model received user event');

        $user = $this->finder->find($event->getUserId());

        if ($user) {
            $user->setName($event->getUsername());
            $user->setPreferredLanguage($event->getPreferredLanguage());
        } else {
            $user = $this->appUserFactory->create(
                $event->getUserId(),
                $event->getUsername(),
                $event->getPreferredLanguage()
            );
        }

        $this->finder->save($user);
    }

    /**
     * @param ThirdPartyAccountLinkedEvent $event
     */
    public function handleThirdPartyAccountLinkedEvent(ThirdPartyAccountLinkedEvent $event)
    {
        $this->logger->info('Third party account linked event');

        $this->updateUserThirdPartyAccount($event->getUserId(), $event->getThirdPartyAccount());
    }

    /**
     * @param ThirdPartyAccountReplacedEvent $event
     */
    public function handleThirdPartyAccountReplacedEvent(ThirdPartyAccountReplacedEvent $event)
    {
        $this->logger->info('Third party account replaced event');

        $this->updateUserThirdPartyAccount($event->getUserId(), $event->getThirdPartyAccount());
    }

    /**
     * @param ApplicationUserId $userId
     * @param Account           $account
     */
    private function updateUserThirdPartyAccount(ApplicationUserId $userId, Account $account)
    {
        $user = $this->finder->find((string) $userId);

        if (!$user) {
            return;
        }

        $user->setThirdPartyAccount($account);

        $this->finder->save($user);
    }
}
