<?php
namespace MessageApp\Test;

use MessageApp\Error\ErrorEventHandler;
use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Handler\MessageAppCommandHandler;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\UserFactory;
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

    private $errorHandler;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = \Mockery::mock(SourcedUser::class, function ($appUser) {
            $appUser->shouldReceive('getId')->andReturn($this->userId);
            $appUser->shouldReceive('getName')->andReturn($this->userName);
        });
        $this->userBuilder = \Mockery::mock(UserFactory::class);
        $this->userManager = $this->getUserRepository($this->user);
        $this->command = $this->getCreateUserCommand($this->userId, $this->user, 'en');
        $this->errorHandler = \Mockery::mock(ErrorEventHandler::class);
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

        $handler = new MessageAppCommandHandler($this->userBuilder, $this->userManager, $this->errorHandler);

        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertNull($response);
    }

    /**
     * @test
     */
    public function testKO()
    {
        $this->userManager->shouldReceive('save')->andThrow('\\Exception');
        $this->userBuilder->shouldReceive('create')->andThrow('\\Exception');

        $handler = new MessageAppCommandHandler($this->userBuilder, $this->userManager, $this->errorHandler);

        $this->errorHandler
            ->shouldReceive('handle')
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
        $handler = new MessageAppCommandHandler($this->userBuilder, $this->userManager, $this->errorHandler);
        $handler->setLogger(\Mockery::mock(LoggerInterface::class));
    }
}
