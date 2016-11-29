<?php
namespace MessageApp\Test\Listener;

use Faker\Factory;
use League\Event\EventInterface;
use MessageApp\Event\UserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Listener\UserEventHandler;
use MessageApp\Message;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\SourceMessage;
use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Finder\AppUserFinder;
use Mockery\Mock;
use RemiSan\Context\Context;

class UserEventHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $source;

    /** @var string */
    private $contextValue;

    /** @var ApplicationUserId */
    private $userId;

    /** @var string */
    private $userName;

    /** @var ApplicationUser | Mock */
    private $user;

    /** @var Message */
    private $message;

    /** @var Context | Mock */
    private $context;

    /** @var SourceMessage | Mock*/
    private $sourceMessage;

    /** @var UserEvent | Mock */
    private $event;

    /** @var AppUserFinder | Mock */
    private $userFinder;

    /** @var MessageFinder | Mock */
    private $messageFinder;

    /** @var MessageFactory | Mock */
    private $factory;

    /** @var MessageSender | Mock */
    private $messageSender;

    /** @var UserEventHandler */
    private $serviceUnderTest;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $faker = Factory::create();

        $this->event = \Mockery::mock(UserEvent::class);

        $this->contextValue = 'contextValue';
        $this->context = \Mockery::mock(Context::class);
        $this->context->shouldReceive('getValue')->andReturn($this->contextValue);

        $this->source = 'src';
        $this->sourceMessage = \Mockery::mock(SourceMessage::class);
        $this->sourceMessage->shouldReceive('getSource')->andReturn($this->source);

        $this->message = \Mockery::mock(Message::class);

        $this->userId = new ApplicationUserId($faker->uuid);
        $this->userName = $faker->userName;
        $this->user = \Mockery::mock(ApplicationUser::class);
        $this->user->shouldReceive('getId')->andReturn($this->userId);
        $this->user->shouldReceive('getName')->andReturn($this->userName);

        $this->userFinder = \Mockery::mock(AppUserFinder::class);
        $this->messageFinder = \Mockery::mock(MessageFinder::class);
        $this->factory = \Mockery::mock(MessageFactory::class);
        $this->messageSender = \Mockery::mock(MessageSender::class);

        $this->serviceUnderTest = new UserEventHandler(
            $this->userFinder,
            $this->messageFinder,
            $this->factory,
            $this->messageSender
        );
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldNotHandleUnsupportedEvent()
    {
        $this->givenAnUnsupportedEvent();

        $this->assertItWillNotTryToRetrieveUser();
        $this->assertItWillNotSendMessage();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldNotHandleEventWithoutUserId()
    {
        $this->givenEventDoesNotHaveAUserId();

        $this->assertItWillNotTryToRetrieveUser();
        $this->assertItWillNotSendMessage();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldSendMessage()
    {
        $this->givenAValidEvent();
        $this->givenMessageWillBeFoundByContextValue();
        $this->givenTheUserExists();
        $this->givenTheMessageCanBeBuilt();

        $this->assertItWillSendMessage();

        $this->serviceUnderTest->handle($this->event, $this->context);
    }

    /**
     * @test
     */
    public function itShouldNotSendMessage()
    {
        $this->givenAValidEvent();
        $this->givenMessageWillBeFoundByContextValue();
        $this->givenTheUserExists();
        $this->givenTheMessageCanNotBeBuilt();

        $this->assertItWillNotSendMessage();

        $this->serviceUnderTest->handle($this->event, $this->context);
    }

    private function assertItWillNotSendMessage()
    {
        $this->messageSender->shouldReceive('send')->never();
    }

    private function assertItWillNotTryToRetrieveUser()
    {
        $this->userFinder->shouldReceive('find')->never();
    }

    private function givenEventDoesNotHaveAUserId()
    {
        $this->event->shouldReceive('getUserId')->andReturn(null);
    }

    private function givenAnUnsupportedEvent()
    {
        $this->event = \Mockery::mock(EventInterface::class);
    }

    private function givenMessageWillBeFoundByContextValue()
    {
        $this->messageFinder
            ->shouldReceive('findByReference')
            ->with($this->contextValue)
            ->andReturn($this->sourceMessage);
    }

    private function givenTheUserExists()
    {
        $this->userFinder
            ->shouldReceive('find')
            ->with($this->userId)
            ->andReturn($this->user)
            ->once();
    }

    private function assertItWillSendMessage()
    {
        $this->messageSender
            ->shouldReceive('send')
            ->with($this->message, $this->source)
            ->once();
    }

    private function givenAValidEvent()
    {
        $this->event = \Mockery::mock(UserEvent::class);
        $this->event->shouldReceive('getUserId')->andReturn($this->userId);
        $this->event->shouldReceive('getName')->andReturn('user.event');
    }

    private function givenTheMessageCanBeBuilt()
    {
        $this->factory
            ->shouldReceive('buildMessage')
            ->with([$this->user], $this->event)
            ->andReturn($this->message);
    }

    private function givenTheMessageCanNotBeBuilt()
    {
        $this->factory
            ->shouldReceive('buildMessage')
            ->with([$this->user], $this->event)
            ->andReturn(null);
    }
}
