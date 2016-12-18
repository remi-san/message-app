<?php
namespace MessageApp\Test;

use League\Tactician\CommandBus;
use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Message;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\MessageApplication;
use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\MessageParser;
use MessageApp\Parser\ParsingUser;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\UndefinedApplicationUser;
use Mockery\Mock;

class MessageApplicationTest extends \PHPUnit_Framework_TestCase
{
    /** @var int */
    protected $lastMessageId;

    /** @var MessageFactory | Mock */
    private $factory;

    /** @var MessageParser | Mock */
    private $messageParser;

    /** @var MessageSender | Mock */
    private $messageSender;

    /** @var CommandBus | Mock */
    private $commandBus;

    /** @var NamedCommand | Mock */
    private $command;

    /** @var ParsingUser | Mock */
    private $user;

    /** @var MessageParserException | Mock */
    private $exception;

    /** @var object */
    private $contextMessage;

    /** @var  */
    private $errorMessage;

    /** @var MessageApplication */
    private $serviceUnderTest;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $this->lastMessageId = 1000;

        $this->contextMessage = new \stdClass();

        $this->messageSender = \Mockery::mock(MessageSender::class);
        $this->messageParser = \Mockery::mock(MessageParser::class);
        $this->factory = \Mockery::mock(MessageFactory::class);
        $this->commandBus = \Mockery::spy(CommandBus::class);

        $this->command = \Mockery::mock(NamedCommand::class);
        $this->user = \Mockery::mock(ParsingUser::class);
        $this->exception = \Mockery::mock(MessageParserException::class);

        $this->errorMessage = \Mockery::mock(Message::class);

        $this->serviceUnderTest = new MessageApplication(
            $this->messageSender,
            $this->messageParser,
            $this->factory,
            $this->commandBus
        );
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
        $this->givenMessageIsACommand();

        $this->assertNoMessageWillBeSent();

        $this->serviceUnderTest->handle($this->contextMessage);

        $this->assertCommandHasBeenHandled();
    }

    /**
     * @test
     */
    public function testHandleWithNonCommandMessage()
    {
        $this->givenMessageIsNotACommand();

        $this->assertNoMessageWillBeSent();

        $this->serviceUnderTest->handle($this->contextMessage);

        $this->assertNoCommandHasBeenHandled();
    }

    /**
     * @test
     */
    public function testHandleWithParsingError()
    {
        $this->givenMessageIsNotParsable();
        $this->givenAMessageCanBeGeneratedFromError();

        $this->assertAnErrorMessageWillBeSent();

        $this->serviceUnderTest->handle($this->contextMessage);

        $this->assertNoCommandHasBeenHandled();
    }

    /**
     * @test
     */
    public function testHandleWithParsingErrorWithoutMessage()
    {
        $this->givenMessageIsNotParsable();
        $this->givenAMessageCanNotBeGeneratedFromError();

        $this->assertNoMessageWillBeSent();
        
        $this->serviceUnderTest->handle($this->contextMessage);

        $this->assertNoCommandHasBeenHandled();
    }

    private function givenMessageIsACommand()
    {
        $this->messageParser->shouldReceive('parse')->andReturn($this->command);
    }

    private function givenMessageIsNotACommand()
    {
        $this->messageParser->shouldReceive('parse')->andReturn(null);
    }

    private function givenMessageIsNotParsable()
    {
        $this->user->shouldReceive('getAccount')->andReturn(\Mockery::mock(Account::class));
        $this->exception->shouldReceive('getUser')->andReturn($this->user);
        $this->messageParser->shouldReceive('parse')->andThrow($this->exception);
    }

    private function givenAMessageCanBeGeneratedFromError()
    {
        $this->factory
            ->shouldReceive('buildMessage')
            ->with(
                \Mockery::on(function ($users) {
                    $this->assertCount(1, $users);
                    $this->assertInstanceOf(UndefinedApplicationUser::class, $users[0]);
                    return true;
                }),
                $this->exception
            )
            ->andReturn($this->errorMessage);
    }

    private function givenAMessageCanNotBeGeneratedFromError()
    {
        $this->factory
            ->shouldReceive('buildMessage')
            ->with(
                \Mockery::on(function ($users) {
                    $this->assertCount(1, $users);
                    $this->assertInstanceOf(UndefinedApplicationUser::class, $users[0]);
                    return true;
                }),
                $this->exception
            )
            ->andReturn(null);
    }

    private function assertCommandHasBeenHandled()
    {
        $this->commandBus->shouldHaveReceived('handle')->with($this->command)->once();
    }

    private function assertNoCommandHasBeenHandled()
    {
        $this->commandBus->shouldNotHaveReceived('handle');
    }

    private function assertNoMessageWillBeSent()
    {
        $this->messageSender->shouldReceive('send')->never();
    }

    private function assertAnErrorMessageWillBeSent()
    {
        $this->messageSender->shouldReceive('send')->with($this->errorMessage, $this->contextMessage)->once();
    }
}
