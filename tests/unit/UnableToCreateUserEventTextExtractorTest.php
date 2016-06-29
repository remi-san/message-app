<?php

namespace MessageApp\Test;

use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Message\TextExtractor\UnableToCreateUserEventTextExtractor;
use RemiSan\Intl\TranslatableResource;

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
        $event = \Mockery::mock(UnableToCreateUserEvent::class);

        $extractor = new UnableToCreateUserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage($event);

        $this->assertEquals(new TranslatableResource('user.created.failed'), $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new UnableToCreateUserEventTextExtractor();

        $extractedMessage = $extractor->extractMessage(null);

        $this->assertNull($extractedMessage);
    }
}
