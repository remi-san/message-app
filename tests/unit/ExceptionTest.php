<?php
namespace MessageApp\Test;

use MessageApp\MessageAppException;
use MessageApp\Test\Mock\MessageAppMocker;

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
    public function testConstructor()
    {

        $exception = new MessageAppException($this->user);

        $this->assertEquals($this->user, $exception->getUser());
    }
}
