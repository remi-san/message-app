<?php
namespace MessageApp\Test;

use MessageApp\Application\Response\HandshakeResponse;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\Test\Mock\MessageAppMocker;

class ApplicationResponseTest extends \PHPUnit_Framework_TestCase {
    use MessageAppMocker;

    /**
     * @test
     */
    public function testSendMessage()
    {
        $message = 'message';
        $user = $this->getApplicationUser(42, 'adam');

        $response = new SendMessageResponse($user, $message);

        $this->assertEquals($user, $response->getUser());
        $this->assertEquals($message, $response->getMessage());
    }

    /**
     * @test
     */
    public function testHandshake()
    {
        $user = $this->getApplicationUser(42, 'adam');

        $response = new HandshakeResponse($user);

        $this->assertEquals($user, $response->getUser());
    }
} 