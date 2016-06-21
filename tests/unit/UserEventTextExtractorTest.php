<?php

namespace MessageApp\Test;

use MessageApp\Event\UserEvent;
use MessageApp\Message\TextExtractor\MessageTextExtractor;
use MessageApp\Message\TextExtractor\UserEventTextExtractor;

class UserEventExceptionTextExtractorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testWithUserEvent()
    {
        $message = 'test-message';
        $gameResult = \Mockery::mock(UserEvent::class);
        $extractor = \Mockery::mock(MessageTextExtractor::class, function ($result) use ($message, $gameResult) {
            $result->shouldReceive('extractMessage')
                ->with($gameResult)
                ->andReturn($message)
                ->once();
        });

        $extractor = new UserEventTextExtractor([$extractor]);

        $extractedMessage = $extractor->extractMessage($gameResult);

        $this->assertEquals($message, $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithUnmanagedUserEvent()
    {
        $gameResult = \Mockery::mock(UserEvent::class);

        $extractor = new UserEventTextExtractor([]);

        $this->setExpectedException(\InvalidArgumentException::class);
        $extractor->extractMessage($gameResult);
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new UserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage(null);

        $this->assertNull($extractedMessage);
    }
}
