<?php
namespace MessageApp\Test\Listener;

use Faker\Factory;
use League\Event\EventInterface;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Listener\UnableToCreateUserEventHandler;
use MessageApp\Message;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\SourceMessage;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\UndefinedApplicationUser;
use Mockery\Mock;
use RemiSan\Context\Context;

class UnableToCreateUserEventHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $source;

    /** @var string */
    private $contextValue;

    /** @var UndefinedApplicationUser */
    private $user;

    /** @var Message */
    private $message;

    /** @var Context | Mock */
    private $context;

    /** @var SourceMessage | Mock*/
    private $sourceMessage;

    /** @var UnableToCreateUserEvent */
    private $event;

    /** @var MessageFinder | Mock */
    private $messageFinder;

    /** @var MessageSender | Mock */
    private $messageSender;

    /** @var MessageFactory | Mock */
    private $factory;

    /** @var UnableToCreateUserEventHandler */
    private $serviceUnderTest;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $faker = Factory::create();

        $this->user = new UndefinedApplicationUser(\Mockery::mock(Account::class));

        $this->message = \Mockery::mock(Message::class);

        $this->contextValue = 'contextValue';
        $this->context = \Mockery::mock(Context::class);
        $this->context->shouldReceive('getValue')->andReturn($this->contextValue);

        $this->source = 'src';
        $this->sourceMessage = \Mockery::mock(SourceMessage::class);
        $this->sourceMessage->shouldReceive('getSource')->andReturn($this->source);

        $this->event = new UnableToCreateUserEvent(
            new ApplicationUserId($faker->uuid),
            $this->user
        );

        $this->messageFinder = \Mockery::mock(MessageFinder::class);
        $this->factory = \Mockery::mock(MessageFactory::class);
        $this->messageSender = \Mockery::mock(MessageSender::class);

        $this->serviceUnderTest = new UnableToCreateUserEventHandler(
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
    public function itShouldNotBeAbleToHandle()
    {
        $this->event = \Mockery::mock(EventInterface::class);

        $this->assertItWillNotSendMessage();

        $this->serviceUnderTest->handle($this->event);
    }

    /**
     * @test
     */
    public function itShouldSendMessage()
    {
        $this->givenMessageMatchingContextExists();
        $this->givenMessageCanBeBuilt();

        $this->assertItWillSendMessage();

        $this->serviceUnderTest->handle($this->event, $this->context);
    }

    /**
     * @test
     */
    public function itShouldNotSendMessage()
    {
        $this->givenMessageMatchingContextExists();
        $this->givenMessageCanNotBeBuilt();

        $this->assertItWillNotSendMessage();

        $this->serviceUnderTest->handle($this->event, $this->context);
    }

    private function givenMessageMatchingContextExists()
    {
        $this->messageFinder
            ->shouldReceive('findByReference')
            ->with($this->contextValue)
            ->andReturn($this->sourceMessage);
    }

    private function givenMessageCanBeBuilt()
    {
        $this->factory
            ->shouldReceive('buildMessage')
            ->with([$this->user], $this->event)
            ->andReturn($this->message);
    }

    private function givenMessageCanNotBeBuilt()
    {
        $this->factory
            ->shouldReceive('buildMessage')
            ->with([$this->user], $this->event)
            ->andReturn(null);
    }

    private function assertItWillSendMessage()
    {
        $this->messageSender
            ->shouldReceive('send')
            ->with($this->message, $this->source)
            ->once();
    }

    private function assertItWillNotSendMessage()
    {
        $this->messageSender
            ->shouldReceive('send')
            ->never();
    }
}
