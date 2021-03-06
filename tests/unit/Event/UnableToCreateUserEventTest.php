<?php
namespace MessageApp\Test\Event;

use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\UndefinedApplicationUser;
use Mockery\Mock;

class UnableToCreateUserEventTest extends \PHPUnit_Framework_TestCase
{
    /** @var UndefinedApplicationUser | Mock */
    private $user;

    /** @var ApplicationUserId | Mock */
    private $userId;

    public function setUp()
    {
        $this->userId = \Mockery::mock(ApplicationUserId::class);
        $this->user = \Mockery::mock(UndefinedApplicationUser::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldCreateTheEvent()
    {
        $event = new UnableToCreateUserEvent($this->userId, $this->user);

        $this->assertEquals($this->userId, $event->getUserId());
        $this->assertEquals($this->user, $event->getUser());
    }
}
