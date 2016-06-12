<?php
namespace MessageApp\Test;

use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\UndefinedApplicationUser;

class UnableToCreateUserEventTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;
    private $user;

    public function setUp()
    {
        $this->user = \Mockery::mock(UndefinedApplicationUser::class);
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
        $event = new UnableToCreateUserEvent($this->user);

        $this->assertEquals($this->user, $event->getUser());
    }
}
