<?php
namespace MessageApp\Test;

use MessageApp\Application\Command\CreateUserCommand;
use MessageApp\Application\Handler\MessageAppCommandHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\Test\Mock\MessageAppMocker;

class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $userId;
    private $userName = 'player';

    private $user;

    private $userManager;

    private $command;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = $this->getApplicationUser($this->userId, $this->userName);
        $this->userManager = $this->getUserManager($this->user);
        $this->command = $this->getCreateUserCommand($this->user);
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

        $handler = new MessageAppCommandHandler($this->userManager);
        $handler->setLogger(\Mockery::mock('\\Psr\\Log\\LoggerInterface'));

        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertTrue($response instanceof SendMessageResponse);
        $this->assertEquals($this->user, $response->getUser());
        $this->assertEquals('Welcome!', $response->getMessage());
    }

    /**
     * @test
     */
    public function testKO()
    {
        $this->userManager->shouldReceive('save')->andThrow('\\Exception');

        $handler = new MessageAppCommandHandler($this->userManager);
        $handler->setLogger(\Mockery::mock('\\Psr\\Log\\LoggerInterface'));

        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertTrue($response instanceof SendMessageResponse);
        $this->assertEquals($this->user, $response->getUser());
        $this->assertEquals('Could not create the player!', $response->getMessage());
    }
}
