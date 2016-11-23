<?php
namespace MessageApp\Test\Handler;

use Faker\Factory;
use MessageApp\Command\CreateUserCommand;
use MessageApp\Error\ErrorEventHandler;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Handler\MessageAppCommandHandler;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\Repository\EventSourced\UserEventSourcedRepository;
use MessageApp\User\Repository\UserRepository;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\AccountFactory;
use MessageApp\User\UserFactory;
use Mockery\Mock;

class MessageAppCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApplicationUserId */
    private $userId;

    /** @var string */
    private $userName;

    /** @var string */
    private $language;

    /** @var SourcedUser | Mock */
    private $user;

    /** @var Account */
    private $account;

    /** @var CreateUserCommand */
    private $command;

    /** @var UserFactory | Mock */
    private $userFactory;

    /** @var UserRepository | Mock */
    private $userRepository;

    /** @var ErrorEventHandler | Mock */
    private $errorHandler;

    /** @var AccountFactory | Mock */
    private $accountFactory;

    /** @var MessageAppCommandHandler */
    private $serviceUnderTest;

    public function setUp()
    {
        $faker = Factory::create();

        $this->userId  = new ApplicationUserId($faker->uuid);
        $this->userName = $faker->userName;
        $this->language = $faker->countryISOAlpha3;
        $this->account = \Mockery::mock(Account::class);

        $this->user = \Mockery::mock(SourcedUser::class);

        $this->command = CreateUserCommand::create($this->userId, $this->user, $this->language);

        $this->userFactory = \Mockery::mock(UserFactory::class);
        $this->accountFactory = \Mockery::mock(AccountFactory::class);

        $this->userRepository = \Mockery::spy(UserEventSourcedRepository::class);
        $this->errorHandler = \Mockery::spy(ErrorEventHandler::class);

        $this->serviceUnderTest = new MessageAppCommandHandler(
            $this->userFactory,
            $this->userRepository,
            $this->accountFactory,
            $this->errorHandler
        );

    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldCreateAUser()
    {
        $this->givenAUserWillBeBuilt();

        $this->serviceUnderTest->handleCreateUserCommand($this->command);

        $this->assertUserHasBeenPersisted();
    }

    /**
     * @test
     */
    public function itShouldFailCreatingAUser()
    {
        $this->givenAUserCannotBeBuilt();

        $this->assertErrorWillBeHandled();

        $this->serviceUnderTest->handleCreateUserCommand($this->command);

        $this->assertUserHasNotBeenPersisted();
    }

    private function givenAUserWillBeBuilt()
    {
        $this->userFactory->shouldReceive('create')->andReturn($this->user);
    }

    private function assertUserHasBeenPersisted()
    {
        $this->userRepository
            ->shouldHaveReceived('save')
            ->with($this->user)
            ->once();
    }

    private function givenAUserCannotBeBuilt()
    {
        $this->userFactory->shouldReceive('create')->andThrow(\Exception::class);
    }

    private function assertErrorWillBeHandled()
    {
        $this->accountFactory->shouldReceive('build')->andReturn($this->account);
        $this->errorHandler
            ->shouldReceive('handle')
            ->with(\Mockery::on(function ($event) {
                return $event instanceof UnableToCreateUserEvent;
            }), null)
            ->once();
    }

    private function assertUserHasNotBeenPersisted()
    {
        $this->userRepository->shouldNotHaveReceived('save');
    }
}
