<?php
namespace MessageApp\Test;

use MessageApp\MessageAppException;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Exception\UnsupportedUserException;
use MessageApp\User\Exception\UserNotFoundException;

class ExceptionTest extends \PHPUnit_Framework_TestCase
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
    public function testMessageAppConstructor()
    {

        $exception = new MessageAppException($this->user);

        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testUnsupportedUserConstructor()
    {

        $exception = new UnsupportedUserException();

        $this->assertNull($exception->getUser());
    }

    /**
     * @test
     */
    public function testUserNotFoundConstructor()
    {

        $exception = new UserNotFoundException($this->user);

        $this->assertNull($exception->getUser());
    }
}
