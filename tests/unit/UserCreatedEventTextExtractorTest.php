<?php

namespace MessageApp\Test;

use MessageApp\Event\UserCreatedEvent;
use MessageApp\Message\TextExtractor\UserCreatedEventTextExtractor;
use RemiSan\Intl\TranslatableResource;

class MessageTextExtractorTest extends \PHPUnit_Framework_TestCase
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
    public function testWithUserCreatedEvent()
    {
        $gameResult = \Mockery::mock(UserCreatedEvent::class);

        $extractor = new UserCreatedEventTextExtractor();

        $extractedMessage = $extractor->extractMessage($gameResult);

        $this->assertEquals(new TranslatableResource('user.created'), $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new UserCreatedEventTextExtractor();

        $extractedMessage = $extractor->extractMessage(null);

        $this->assertNull($extractedMessage);
    }
}
