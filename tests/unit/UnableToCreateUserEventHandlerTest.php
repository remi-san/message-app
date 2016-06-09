<?php
namespace MessageApp\Test;

use League\Event\EventInterface;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Listener\UnableToCreateUserEventHandler;
use MessageApp\Message;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\SourceMessage;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\UndefinedApplicationUser;
use Psr\Log\LoggerInterface;
use RemiSan\Context\Context;

class UnableToCreateUserEventHandlerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    /**
     * @var MessageFinder
     */
    private $messageFinder;

    /**
     * @var MessageFactory
     */
    private $factory;

    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $this->messageFinder = \Mockery::mock(MessageFinder::class);

        $this->messageSender = $this->getMessageSender();

        $this->factory = \Mockery::mock(MessageFactory::class);

        $this->logger = \Mockery::mock('\\Psr\\Log\\LoggerInterface');
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testUnsupportedEvent()
    {
        $listener = new UnableToCreateUserEventHandler(
            $this->messageFinder,
            $this->factory,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

        $this->messageSender->shouldReceive('send')->never();

        $event = \Mockery::mock(EventInterface::class);
        $listener->handle($event);
    }

    /**
     * @test
     */
    public function testCompleteEvent()
    {
        $user = \Mockery::mock(UndefinedApplicationUser::class, function ($user) {
            $user->shouldReceive('getName')->andReturn('user');
        });
        $messageText = 'test';
        $source = 'src';
        $message = \Mockery::mock(Message::class);

        $context = \Mockery::mock(Context::class, function ($context) {
            $context->shouldReceive('getValue')->andReturn('contextValue');
        });

        $sourceMessage = \Mockery::mock(SourceMessage::class, function ($sourceMessage) use ($source) {
            $sourceMessage->shouldReceive('getSource')->andReturn($source);
        });

        $this->messageFinder->shouldReceive('findByReference')->with('contextValue')->andReturn($sourceMessage);

        $listener = new UnableToCreateUserEventHandler(
            $this->messageFinder,
            $this->factory,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

        $this->messageSender
            ->shouldReceive('send')
            ->with($message, $source)
            ->once();

        $event = \Mockery::mock(UnableToCreateUserEvent::class, function ($event) use ($user, $messageText) {
            $event->shouldReceive('getUser')->andReturn($user);
            $event->shouldReceive('getReason')->andReturn($messageText);
            $event->shouldReceive('getName')->andReturn(UnableToCreateUserEvent::NAME);
        });

        $this->factory
            ->shouldReceive('buildMessage')
            ->with([$user], $event)
            ->andReturn($message);

        $listener->handle($event, $context);
    }

    /**
     * @test
     */
    public function testCompleteEventNoMessage()
    {
        $user = \Mockery::mock(UndefinedApplicationUser::class, function ($user) {
            $user->shouldReceive('getName')->andReturn('user');
        });
        $messageText = 'test';
        $source = 'src';

        $context = \Mockery::mock(Context::class, function ($context) {
            $context->shouldReceive('getValue')->andReturn('contextValue');
        });

        $sourceMessage = \Mockery::mock(SourceMessage::class, function ($sourceMessage) use ($source) {
            $sourceMessage->shouldReceive('getSource')->andReturn($source);
        });

        $this->messageFinder->shouldReceive('findByReference')->with('contextValue')->andReturn($sourceMessage);

        $listener = new UnableToCreateUserEventHandler(
            $this->messageFinder,
            $this->factory,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');
        $this->logger->shouldReceive('warning');

        $this->messageSender
            ->shouldReceive('send')
            ->never();

        $event = \Mockery::mock(UnableToCreateUserEvent::class, function ($event) use ($user, $messageText) {
            $event->shouldReceive('getUser')->andReturn($user);
            $event->shouldReceive('getReason')->andReturn($messageText);
            $event->shouldReceive('getName')->andReturn(UnableToCreateUserEvent::NAME);
        });

        $this->factory
            ->shouldReceive('buildMessage')
            ->with([$user], $event)
            ->andReturn(null);

        $listener->handle($event, $context);
    }
}
