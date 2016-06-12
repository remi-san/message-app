<?php

namespace MessageApp\Test;

use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Message\TextExtractor\UnableToCreateUserEventTextExtractor;

class UnableToCreateUserEventExceptionTextExtractorTest extends \PHPUnit_Framework_TestCase
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
    public function testWithUnableToCreateUserEvent()
    {
        $message = 'test-message';
        $event = \Mockery::mock(UnableToCreateUserEvent::class, function ($event) use ($message) {
            $event->shouldReceive('getReason')->andReturn($message);
        });

        $extractor = new UnableToCreateUserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage($event, 'en');

        $this->assertEquals($message, $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new UnableToCreateUserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage(null, 'en');

        $this->assertNull($extractedMessage);
    }
}
