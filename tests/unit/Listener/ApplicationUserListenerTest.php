<?php

namespace MessageApp\Test\Listener;

use Faker\Factory;
use League\Event\EventInterface;
use MessageApp\Event\ThirdPartyAccountLinkedEvent;
use MessageApp\Event\ThirdPartyAccountReplacedEvent;
use MessageApp\Event\UserCreatedEvent;
use MessageApp\Listener\ApplicationUserFactory;
use MessageApp\Listener\ApplicationUserListener;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\PersistableUser;
use MessageApp\User\Store\ApplicationUserStore;
use MessageApp\User\ThirdParty\Account;
use Mockery\Mock;

class ApplicationUserListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApplicationUserId */
    private $applicationUserId;

    /** @var string */
    private $username;

    /** @var string */
    private $preferredLanguage;

    /** @var PersistableUser | Mock */
    private $user;

    /** @var Account */
    private $thirdPartyAccount;

    /** @var EventInterface */
    private $event;

    /** @var ApplicationUserFactory | Mock */
    private $applicationUserFactory;

    /** @var ApplicationUserStore | Mock */
    private $appUserStore;

    /** @var ApplicationUserListener */
    private $serviceUnderTest;

    /**
     * Init
     */
    public function setUp()
    {
        $faker = Factory::create();

        $this->applicationUserId = new ApplicationUserId($faker->uuid);
        $this->username = $faker->userName;
        $this->preferredLanguage = $faker->countryISOAlpha3;

        $this->user = \Mockery::mock(PersistableUser::class);
        $this->thirdPartyAccount = \Mockery::mock(Account::class);

        $this->applicationUserFactory = \Mockery::mock(ApplicationUserFactory::class);
        $this->appUserStore = \Mockery::mock(ApplicationUserStore::class);

        $this->serviceUnderTest = new ApplicationUserListener(
            $this->applicationUserFactory,
            $this->appUserStore
        );
    }

    /**
     * Close
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldCreateANewUser()
    {
        $this->givenIHaveAUserCratedEvent();
        $this->givenTheUserDoesNotExist();

        $this->assertUserWillBeCreated();
        $this->assertUserWillBeSaved();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldUpdateTheUserInformation()
    {
        $this->givenIHaveAUserCratedEvent();
        $this->givenTheUserExists();

        $this->assertUserWillNotBeCreated();
        $this->assertUserWillBeUpdated();
        $this->assertUserWillBeSaved();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldLinkTheUserToAThirdPartyAccount()
    {
        $this->givenIHaveAThirdPartyAccountLinkedEvent();
        $this->givenTheUserExists();

        $this->assertUserWillBeLinkedToThirdPartyAccount();
        $this->assertUserWillBeSaved();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldNotLinkTheUserToAThirdPartyAccount()
    {
        $this->givenIHaveAThirdPartyAccountLinkedEvent();
        $this->givenTheUserDoesNotExist();

        $this->assertUserWillNotBeLinkedToThirdPartyAccount();
        $this->assertUserWillNotBeSaved();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldReplaceTheLinkBetweenTheUserAndTheThirdPartyAccount()
    {
        $this->givenIHaveAThirdPartyAccountReplacedEvent();
        $this->givenTheUserExists();

        $this->assertUserWillBeLinkedToThirdPartyAccount();
        $this->assertUserWillBeSaved();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldNotReplaceTheLinkBetweenTheUserAndTheThirdPartyAccount()
    {
        $this->givenIHaveAThirdPartyAccountReplacedEvent();
        $this->givenTheUserDoesNotExist();

        $this->assertUserWillNotBeLinkedToThirdPartyAccount();
        $this->assertUserWillNotBeSaved();

        $this->serviceUnderTest->handle($this->event);
    }

    private function givenIHaveAUserCratedEvent()
    {
        $this->event = new UserCreatedEvent(
            $this->applicationUserId,
            $this->username,
            $this->preferredLanguage
        );
    }

    private function givenTheUserDoesNotExist()
    {
        $this->appUserStore
            ->shouldReceive('find')
            ->with((string) $this->applicationUserId)
            ->andReturnNull();
    }

    private function givenTheUserExists()
    {
        $this->appUserStore
            ->shouldReceive('find')
            ->with((string) $this->applicationUserId)
            ->andReturn($this->user);
    }

    private function assertUserWillBeCreated()
    {
        $this->applicationUserFactory
            ->shouldReceive('create')
            ->with(
                $this->applicationUserId,
                $this->username,
                $this->preferredLanguage
            )->andReturn($this->user)
            ->once();
    }

    private function assertUserWillNotBeCreated()
    {
        $this->applicationUserFactory
            ->shouldReceive('create')
            ->never();
    }

    private function assertUserWillBeUpdated()
    {
        $this->user
            ->shouldReceive('setName')
            ->with($this->username)
            ->once();

        $this->user
            ->shouldReceive('setPreferredLanguage')
            ->with($this->preferredLanguage)
            ->once();
    }

    private function assertUserWillBeSaved()
    {
        $this->appUserStore
            ->shouldReceive('save')
            ->with($this->user)
            ->once();
    }

    private function assertUserWillNotBeSaved()
    {
        $this->appUserStore
            ->shouldReceive('save')
            ->with($this->user)
            ->never();
    }

    /**
     * @return ThirdPartyAccountLinkedEvent
     */
    private function givenIHaveAThirdPartyAccountLinkedEvent()
    {
        return $this->event = new ThirdPartyAccountLinkedEvent(
            $this->applicationUserId,
            $this->thirdPartyAccount
        );
    }

    private function givenIHaveAThirdPartyAccountReplacedEvent()
    {
        $this->event = new ThirdPartyAccountReplacedEvent(
            $this->applicationUserId,
            $this->thirdPartyAccount
        );
    }

    private function assertUserWillBeLinkedToThirdPartyAccount()
    {
        $this->user
            ->shouldReceive('setThirdPartyAccount')
            ->with($this->thirdPartyAccount)
            ->once();
    }

    private function assertUserWillNotBeLinkedToThirdPartyAccount()
    {
        $this->user
            ->shouldReceive('setThirdPartyAccount')
            ->with($this->thirdPartyAccount)
            ->never();
    }
}
