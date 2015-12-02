<?php
namespace MessageApp\Test;

use MessageApp\Application\Handler\MessageAppCommandHandler;
use MessageApp\Application\Message\DefaultMessage;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Exception\AppUserException;
use Psr\Log\LoggerInterface;

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
        $this->userManager->shouldReceive('create')->andReturn($this->user);

        $handler = new MessageAppCommandHandler($this->userManager);

        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertTrue($response instanceof DefaultMessage);
        $this->assertEquals($this->user, $response->getUser());
        $this->assertEquals('Welcome!', $response->getMessage());
    }

    /**
     * @test
     */
    public function testKO()
    {
        $this->userManager->shouldReceive('save')->andThrow('\\Exception');
        $this->userManager->shouldReceive('create')->andThrow(new AppUserException($this->user));

        $handler = new MessageAppCommandHandler($this->userManager);

        $response = $handler->handleCreateUserCommand($this->command);

        $this->assertTrue($response instanceof DefaultMessage);
        $this->assertEquals($this->user, $response->getUser()->getOriginalUser());
        $this->assertEquals('Could not create the user!', $response->getMessage());
    }

    /**
     * @test
     */
    public function testHandler()
    {
        $handler = new MessageAppCommandHandler($this->userManager);
        $handler->setLogger(\Mockery::mock(LoggerInterface::class));
    }
}
