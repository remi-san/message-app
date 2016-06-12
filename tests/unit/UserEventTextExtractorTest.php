<?php

namespace MessageApp\Test;

use MessageApp\Event\UserEvent;
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
        $event = \Mockery::mock(UserEvent::class, function ($event) use ($message) {
            $event->shouldReceive('getAsMessage')->andReturn($message);
        });

        $extractor = new UserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage($event, 'en');

        $this->assertEquals($message, $extractedMessage);
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
