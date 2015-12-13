<?php
namespace MessageApp\Test;

use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Handler\MessageAppCommandHandler;
use MessageApp\Message\DefaultMessage;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Exception\AppUserException;
use MessageApp\User\UserBuilder;
use Psr\Log\LoggerInterface;

class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $userId;
    private $userName = 'player';

    private $user;

    private $userBuilder;

    private $userManager;

    private $command;

    private $eventEmitter;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = $this->getApplicationUser($this->userId, $this->userName);
        $this->userBuilder = \Mockery::mock(UserBuilder::class);
        $this->userManager = $this->getUserManager($this->user);
        $this->command = $this->getCreateUserCommand($this->user);
        $this->eventEmitter = \Mockery::mock('League\Event\EmitterInterface');
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testOK()
    {
        $this->userManager->shouldReceive('save')->once();
        $this->userBuilder->shouldReceive('create')->andReturn($this->user);

        $handler = new MessageAppCommandHandler($this->userBuilder, $this->userManager, $this->eventEmitter);

        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertNull($response);
    }

    /**
     * @test
     */
    public function testKO()
    {
        $this->userManager->shouldReceive('save')->andThrow('\\Exception');
        $this->userBuilder->shouldReceive('create')->andThrow(new AppUserException($this->user));

        $handler = new MessageAppCommandHandler($this->userBuilder, $this->userManager, $this->eventEmitter);

        $this->eventEmitter
            ->shouldReceive('emit')
            ->with(\Mockery::on(function ($event) {
                return $event instanceof UnableToCreateUserEvent;
            }))
            ->once();


        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertNull($response);
    }

    /**
     * @test
     */
    public function testHandler()
    {
        $handler = new MessageAppCommandHandler($this->userBuilder, $this->userManager, $this->eventEmitter);
        $handler->setLogger(\Mockery::mock(LoggerInterface::class));
    }
}
