<?php
namespace MessageApp\Test;

use MessageApp\Command\CreateUserCommand;
use MessageApp\Test\Mock\MessageAppMocker;
use RemiSan\Context\Context;

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
        $context = \Mockery::mock(Context::class);
        $language = 'en';

        $command = CreateUserCommand::create($this->userId, $this->user, $language, $context);

        $this->assertEquals($this->userId, $command->getId());
        $this->assertEquals($this->user, $command->getOriginalUser());
        $this->assertEquals(CreateUserCommand::NAME, $command->getCommandName());
        $this->assertEquals($context, $command->getContext());
        $this->assertEquals($language, $command->getPreferredLanguage());
    }
}
