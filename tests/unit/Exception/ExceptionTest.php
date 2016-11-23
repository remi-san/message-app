<?php
namespace MessageApp\Test\Exception;

use MessageApp\Exception\MessageAppException;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Exception\UnsupportedUserException;

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

        new MessageAppException();
    }

    /**
     * @test
     */
    public function testUnsupportedUserConstructor()
    {

        new UnsupportedUserException();
    }
}
