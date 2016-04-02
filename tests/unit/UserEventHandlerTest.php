<?php
namespace MessageApp\Test;

use League\Event\EventInterface;
use MessageApp\Event\UserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Listener\UserEventHandler;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Finder\AppUserFinder;
use Psr\Log\LoggerInterface;

class UserEventHandlerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    /**
     * @var AppUserFinder
     */
    private $userFinder;

    /**
     * @var MessageFinder
     */
    private $messageFinder;

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
        $this->userFinder = \Mockery::mock(AppUserFinder::class);

        $this->messageFinder = \Mockery::mock(MessageFinder::class);

        $this->messageSender = $this->getMessageSender();

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
        $listener = new UserEventHandler(
            $this->userFinder,
            $this->messageFinder,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

        $this->userFinder->shouldReceive('find')->never();
        $this->messageSender->shouldReceive('send')->never();

        $event = \Mockery::mock(EventInterface::class);
        $listener->handle($event);
    }

    /**
     * @test
     */
    public function testIncompleteEvent()
    {
        $listener = new UserEventHandler(
            $this->userFinder,
            $this->messageFinder,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

        $this->userFinder->shouldReceive('find')->never();
        $this->messageSender->shouldReceive('send')->never();

        $event = \Mockery::mock(UserEvent::class, function ($event) {
            $event->shouldReceive('getUserId')->andReturn(null);
            $event->shouldReceive('getAsMessage')->andReturn('message');
        });
        $listener->handle($event);
    }

    /**
     * @test
     */
    public function testIncompleteEvent2()
    {
        $listener = new UserEventHandler(
            $this->userFinder,
            $this->messageFinder,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

        $this->userFinder->shouldReceive('find')->never();
        $this->messageSender->shouldReceive('send')->never();

        $event = \Mockery::mock(UserEvent::class, function ($event) {
            $event->shouldReceive('getUserId')->andReturn(\Mockery::mock(ApplicationUserId::class));
            $event->shouldReceive('getAsMessage')->andReturn(null);
        });
        $listener->handle($event);
    }

    /**
     * @test
     */
    public function testCompleteEvent()
    {
        $userId = $this->getApplicationUserId(42);
        $user = $this->getApplicationUser($userId, 'Douglas');
        $messageText = 'test';

        $listener = new UserEventHandler(
            $this->userFinder,
            $this->messageFinder,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

        $this->userFinder
            ->shouldReceive('find')
            ->with($userId)
            ->andReturn($user)
            ->once();
        $this->messageSender
            ->shouldReceive('send')
            ->with(
                \Mockery::on(function ($message) use ($messageText) {
                    return $message instanceof DefaultMessage &&
                        $message->getMessage() === $messageText;
                }),
                null
            )
            ->once();

        $event = \Mockery::mock(UserEvent::class, function ($event) use ($userId, $messageText) {
            $event->shouldReceive('getUserId')->andReturn($userId);
            $event->shouldReceive('getAsMessage')->andReturn($messageText);
            $event->shouldReceive('getName')->andReturn('user.event');
        });
        $listener->handle($event);
    }
}
