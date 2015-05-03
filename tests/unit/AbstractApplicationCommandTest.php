<?php
namespace MessageApp\Test;

use MessageApp\Application\Command\AbstractApplicationCommand;
use MessageApp\Test\Mock\MessageAppMocker;

class TestCommand extends AbstractApplicationCommand {}

class AbstractApplicationCommandTest extends \PHPUnit_Framework_TestCase {
    use MessageAppMocker;

    /**
     * @test
     */
    public function testWithTwitterMessage()
    {
        $user = $this->getApplicationUser(42, 'Adam');

        $command = new TestCommand($user);
        $returnUser = $command->getUser();

        $this->assertEquals($user, $returnUser);
    }
}