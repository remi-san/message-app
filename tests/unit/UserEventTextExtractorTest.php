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
        $lang = 'en';
        $gameResult = \Mockery::mock(UserEvent::class);
        $extractor = \Mockery::mock(MessageTextExtractor::class, function ($result) use ($message, $gameResult, $lang) {
            $result->shouldReceive('extractMessage')
                ->with($gameResult, $lang)
                ->andReturn($message)
                ->once();
        });

        $extractor = new UserEventTextExtractor([$extractor]);

        $extractedMessage = $extractor->extractMessage($gameResult, $lang);

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
        $extractor->extractMessage($gameResult, 'en');
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new UserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage(null, 'en');

        $this->assertNull($extractedMessage);
    }
}
