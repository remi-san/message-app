<?php

namespace MessageApp\Test\Message\TextExtractor;

use MessageApp\Event\UnableToCreateUserEvent;
use MessageApp\Message\TextExtractor\UnableToCreateUserEventTextExtractor;
use RemiSan\Intl\TranslatableResource;

class UnableToCreateUserEventExceptionTextExtractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var UnableToCreateUserEvent */
    private $event;

    /** @var UnableToCreateUserEventTextExtractor */
    private $serviceUnderTest;

    public function setUp()
    {
        $this->event = \Mockery::mock(UnableToCreateUserEvent::class);

        $this->serviceUnderTest = new UnableToCreateUserEventTextExtractor();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldExtractMessageFromEvent()
    {
        $extractedMessage = $this->serviceUnderTest->extractMessage($this->event);

        $this->assertEquals(
            new TranslatableResource(UnableToCreateUserEventTextExtractor::MESSAGE_KEY),
            $extractedMessage
        );
    }

    /**
     * @test
     */
    public function itShouldNotExtractMessage()
    {
        $extractedMessage = $this->serviceUnderTest->extractMessage(null);

        $this->assertNull($extractedMessage);
    }
}
