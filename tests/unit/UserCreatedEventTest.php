<?php
namespace MessageApp\Test;

use MessageApp\Event\UserCreatedEvent;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\ApplicationUserId;

class UserCreatedEventTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    /**
     * @var ApplicationUserId
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    public function setUp()
    {
        $this->id = $this->getApplicationUserId(33);
        $this->username = 'john';
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testAccessors()
    {
        $language = 'en';
        $event = new UserCreatedEvent($this->id, $this->username, $language);

        $this->assertEquals($this->id, $event->getUserId());
        $this->assertEquals($this->username, $event->getUsername());
        $this->assertEquals($language, $event->getPreferredLanguage());
    }
}
