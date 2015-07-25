<?php
namespace MessageApp\Test;

use MessageApp\MessageAppException;
use MessageApp\Test\Mock\MessageAppMocker;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $playerId = 1;
    private $playerName = 'player';

    private $user;

    public function setUp()
    {
        $this->user = $this->getApplicationUser($this->playerId, $this->playerName);
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
