<?php
namespace MessageApp\Test;

use MessageApp\Application\Command\CreateUserCommand;
use MessageApp\Test\Mock\MessageAppMocker;

class CreateUserCommandTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $userId;
    private $userName = 'player';

    private $user;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = $this->getApplicationUser($this->userId, $this->userName);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function test()
    {
        $command = new CreateUserCommand($this->user);

        $this->assertEquals($this->user, $command->getOriginalUser());
        $this->assertEquals(CreateUserCommand::NAME, $command->getCommandName());
    }
}
