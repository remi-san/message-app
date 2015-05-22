<?php
namespace MessageApp\Test;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Test\Mock\MessageAppMocker;

class ExceptionTest extends \PHPUnit_Framework_TestCase {
    use MessageAppMocker;

    private $playerId = 1;
    private $playerName = 'user';

    private $user;

    public function setUp()
    {
        $this->user = $this->getApplicationUser($this->playerId, $this->playerName);
    }

    /**
     * @test
     */
    public function testConstructor() {

        $exception = new MessageParserException($this->user);

        $this->assertEquals($this->user, $exception->getUser());
    }
} 