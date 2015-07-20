<?php
namespace MessageApp\Test;

use Hangman\Hangman;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\MessageApplication;
use MessageApp\Test\Mock\MessageAppMocker;
use MiniGame\Player;
use Psr\Log\LoggerInterface;

class MessageAppTest extends \PHPUnit_Framework_TestCase {
    use MessageAppMocker;

    const ID_1 = 1000;

    const ID_2 = 2000;

    const ID_3 = 3000;

    /**
     * @var ApplicationResponseHandler
     */
    private $appResponseHandler;

    /**
     * @var int
     */
    protected $lastMessageId;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Invoke an app method
     *
     * @param  string             $name
     * @param  MessageApplication $obj
     * @param  array              $params
     * @return mixed
     */
    protected function invokeAppMethod($name, MessageApplication $obj, array $params) {
        $class = new \ReflectionClass('\\TwitterMessageApp\\Application\\MiniGameApp');
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $params);
    }

    /**
     * Set a property
     *
     * @param  string             $name
     * @param  MessageApplication $obj
     * @param  mixed              $value
     */
    protected function setAppValue($name, MessageApplication $obj, $value) {
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
    protected function getAppValue($name, MessageApplication $obj) {
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
     * @return Hangman
     */
    protected function retrievePlayerMiniGame(MessageApplication $obj, Player $player) {
        return $this->invokeAppMethod('getPlayerMiniGame', $obj, array($player));
    }

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $this->lastMessageId           = self::ID_1;

        $this->appResponseHandler = $this->getAppResponseHandler();

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
        $userId = 42;
        $userName = 'Arthur';
        $appUser = $this->getApplicationUser($userId, $userName);
        $response = $this->getSendMessageResponse($appUser, '');

        $message = new \stdClass();

        $command = $this->getApplicationCommand($appUser);

        $this->logger->shouldReceive('info')->once();
        $this->appResponseHandler->shouldReceive('handle')->with($response, $message)->once();

        $hangmanApp = new MessageApplication($this->appResponseHandler, $this->getParser($command), $this->getExecutor($response));
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($message);
    }

    /**
     * @test
     */
    public function testHandleWithNonCommandMessage()
    {
        $message = new \stdClass();

        $this->logger->shouldReceive('info')->twice();

        $hangmanApp = new MessageApplication($this->appResponseHandler, $this->getParser(null), $this->getExecutor());
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($message);
    }

    /**
     * @test
     */
    public function testHandleWithParsingError()
    {
        $userId = 42;
        $userName = 'Arthur';
        $user = $this->getApplicationUser($userId, $userName);

        $message = new \stdClass();

        $exception = \Mockery::mock('\\MessageApp\\Parser\\Exception\\MessageParserException');
        $exception->shouldReceive('getUser')->andReturn($user);
        $exception->shouldReceive('getMessage')->andReturn('');

        $parser = \Mockery::mock('\\MessageApp\\Parser\\MessageParser');
        $parser->shouldReceive('parse')->andThrow($exception);

        $this->logger->shouldReceive('info')->once();
        $this->logger->shouldReceive('error')->once();
        $this->appResponseHandler->shouldReceive('handle')->once();

        $hangmanApp = new MessageApplication($this->appResponseHandler, $parser, $this->getExecutor());
        $hangmanApp->setLogger($this->logger);

        $hangmanApp->handle($message);
    }
} 