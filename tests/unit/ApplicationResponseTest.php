<?php
namespace MessageApp\Test;

use MessageApp\Application\Message\DefaultMessage;
use MessageApp\Test\Mock\MessageAppMocker;

class ApplicationResponseTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testSendMessage()
    {
        $message = 'message';
        $user = $this->getApplicationUser($this->getApplicationUserId(42), 'adam');

        $response = new DefaultMessage($user, $message);

        $this->assertEquals($user, $response->getUser());
        $this->assertEquals($message, $response->getMessage());
    }
}
