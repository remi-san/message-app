<?php
namespace MessageApp\Test;

use MessageApp\Message;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\MessageApplication;
use MessageApp\Parser\ParsingUser;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\UndefinedApplicationUser;
use MiniGame\Entity\MiniGame;
use MiniGame\Entity\Player;
use Psr\Log\LoggerInterface;

class MessageAppTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    const ID_1 = 1000;

    const ID_2 = 2000;

    const ID_3 = 3000;

    /**
     * @var int
     */
    protected $lastMessageId;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var MessageFactory
     */
    private $factory;

    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $this->lastMessageId = self::ID_1;

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
    public function testHandleWithMessage()
    {
        $userId = $this->getApplicationUserId(42);
        $userName = 'Arthur';
        $appUser = $this->getApplicationUser($userId, $userName);
        $message = $this->getSendMessageResponse($appUser, '');

        $contextMessage = new \stdClass();

        $command = $this->getApplicationCommand($appUser);

        $this->logger->shouldReceive('info')->once();

        $hangmanApp = new MessageApplication(
            $this->messageSender,
            $this->getParser($command),
            $this->factory,
            $this->getCommandBus($message)
        );
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($contextMessage);
    }

    /**
     * @test
     */
    public function testHandleWithNonCommandMessage()
    {
        $message = new \stdClass();

        $this->logger->shouldReceive('info')->twice();

        $hangmanApp = new MessageApplication(
            $this->messageSender,
            $this->getParser(null),
            $this->factory,
            $this->getCommandBus()
        );
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($message);
    }

    /**
     * @test
     */
    public function testHandleWithParsingError()
    {
        $userId = $this->getApplicationUserId(42);
        $userName = 'Arthur';
        $user = \Mockery::mock(ParsingUser::class, function ($user) use ($userId, $userName) {
            $user->shouldReceive('getId')->andReturn($userId);
            $user->shouldReceive('getName')->andReturn($userName);
            $user->shouldReceive('getAccount')->andReturn(\Mockery::mock(Account::class));
        });
        $message = new \stdClass();
        $errorMessage = \Mockery::mock(Message::class);

        $exception = \Mockery::mock('\\MessageApp\\Parser\\Exception\\MessageParserException');
        $exception->shouldReceive('getUser')->andReturn($user);

        $parser = \Mockery::mock('\\MessageApp\\Parser\\MessageParser');
        $parser->shouldReceive('parse')->andThrow($exception);

        $this->logger->shouldReceive('info')->twice();
        $this->logger->shouldReceive('error')->once();
        $this->messageSender->shouldReceive('send')->with($errorMessage, $message)->once();

        $this->factory
            ->shouldReceive('buildMessage')
            ->with(
                \Mockery::on(function ($users) {
                    $this->assertCount(1, $users);
                    $this->assertInstanceOf(UndefinedApplicationUser::class, $users[0]);
                    return true;
                }),
                $exception
            )
            ->andReturn($errorMessage);

        $hangmanApp = new MessageApplication(
            $this->messageSender,
            $parser,
            $this->factory,
            $this->getCommandBus()
        );
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($message);
    }

    /**
     * @test
     */
    public function testHandleWithParsingErrorWithoutMessage()
    {
        $userId = $this->getApplicationUserId(42);
        $userName = 'Arthur';
        $user = \Mockery::mock(ParsingUser::class, function ($user) use ($userId, $userName) {
            $user->shouldReceive('getId')->andReturn($userId);
            $user->shouldReceive('getName')->andReturn($userName);
            $user->shouldReceive('getAccount')->andReturn(\Mockery::mock(Account::class));
        });
        $message = new \stdClass();

        $exception = \Mockery::mock('\\MessageApp\\Parser\\Exception\\MessageParserException');
        $exception->shouldReceive('getUser')->andReturn($user);

        $parser = \Mockery::mock('\\MessageApp\\Parser\\MessageParser');
        $parser->shouldReceive('parse')->andThrow($exception);

        $this->logger->shouldReceive('info')->twice();
        $this->logger->shouldReceive('error')->once();
        $this->logger->shouldReceive('warning')->once();
        $this->messageSender->shouldReceive('send')->never();

        $this->factory
            ->shouldReceive('buildMessage')
            ->with(
                \Mockery::on(function ($users) {
                    $this->assertCount(1, $users);
                    $this->assertInstanceOf(UndefinedApplicationUser::class, $users[0]);
                    return true;
                }),
                $exception
            )
            ->andReturn(null);

        $hangmanApp = new MessageApplication(
            $this->messageSender,
            $parser,
            $this->factory,
            $this->getCommandBus()
        );
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($message);
    }

    /**
     * Set a property
     *
     * @param  string             $name
     * @param  MessageApplication $obj
     * @param  mixed              $value
     */
    protected function setAppValue($name, MessageApplication $obj, $value)
    {
        $class = new \ReflectionClass('\\TwitterMessageApp\\Application\\MiniGameApp');
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($obj, $value);
    }

    /**
     * Get a property
     *
     * @param  string             $name
     * @param  MessageApplication $obj
     * @return mixed
     */
    protected function getAppValue($name, MessageApplication $obj)
    {
        $class = new \ReflectionClass('\\TwitterMessageApp\\Application\\MiniGameApp');
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        return $property->getValue($obj);
    }

    /**
     * Returns the mini-game for the player
     *
     * @param  MessageApplication $obj
     * @param  Player             $player
     * @return MiniGame
     */
    protected function retrievePlayerMiniGame(MessageApplication $obj, Player $player)
    {
        return $this->invokeAppMethod('getPlayerMiniGame', $obj, array($player));
    }

    /**
     * Invoke an app method
     *
     * @param  string             $name
     * @param  MessageApplication $obj
     * @param  array              $params
     * @return mixed
     */
    protected function invokeAppMethod($name, MessageApplication $obj, array $params)
    {
        $class = new \ReflectionClass('\\TwitterMessageApp\\Application\\MiniGameApp');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $params);
    }
}
