<?php
namespace MessageApp\Test;

use MessageApp\Application\Message\Handler\MessageSendingHandler;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\Test\Mock\MessageResponse;

class MessageResponseHandlerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testWithNullResponse()
    {
        $response = null;
        $context = "context";

        $logger = \Mockery::mock('\\Psr\\Log\\LoggerInterface');

        $sender = $this->getMessageSender();

        $handler = new MessageSendingHandler($sender);
        $handler->setLogger($logger);
        $handler->handle($response, $context);
    }

    /**
     * @test
     */
    public function testWithMessageResponse()
    {
        $response = new MessageResponse();
        $context = "context";

        $logger = \Mockery::mock('\\Psr\\Log\\LoggerInterface');
        $logger->shouldReceive('info')->once();

        $sender = $this->getMessageSender();
        $sender->shouldReceive('send')->with($response, $context);

        $handler = new MessageSendingHandler($sender);
        $handler->setLogger($logger);
        $handler->handle($response, $context);
    }
}
