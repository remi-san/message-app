<?php
namespace MessageApp\Test;

use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\Test\Mock\MessageAppMocker;

class ApplicationResponseTest extends \PHPUnit_Framework_TestCase {
    use MessageAppMocker;

    /**
     * @test
     */
    public function test()
    {
        $message = 'message';
        $user = $this->getApplicationUser(42, 'adam');

        $response = new SendMessageResponse($user, $message);

        $this->assertEquals($user, $response->getUser());
        $this->assertEquals($message, $response->getMessage());
    }
} 