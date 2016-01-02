<?php
namespace MessageApp\Test;

use League\Event\EventInterface;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Finder\MessageFinder;
use MessageApp\Listener\UnableToCreateUserEventHandler;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\UndefinedApplicationUser;
use Psr\Log\LoggerInterface;

class UnableToCreateUserEventHandlerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

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
        $listener = new UnableToCreateUserEventHandler(
            $this->messageFinder,
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
        $user = \Mockery::mock(UndefinedApplicationUser::class);
        $messageText = 'test';

        $listener = new UnableToCreateUserEventHandler(
            $this->messageFinder,
            $this->messageSender
        );

        $listener->setLogger($this->logger);
        $this->logger->shouldReceive('info');

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

        $event = \Mockery::mock(UnableToCreateUserEvent::class, function ($event) use ($user, $messageText) {
            $event->shouldReceive('getUser')->andReturn($user);
            $event->shouldReceive('getReason')->andReturn($messageText);
        });
        $listener->handle($event);
    }
}
