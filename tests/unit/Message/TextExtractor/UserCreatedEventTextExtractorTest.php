<?php

namespace MessageApp\Test\Message\TextExtractor;

use MessageApp\Event\UserCreatedEvent;
use MessageApp\Message\TextExtractor\UserCreatedEventTextExtractor;
use RemiSan\Intl\TranslatableResource;

class MessageTextExtractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserCreatedEvent */
    private $gameResult;

    /** @var UserCreatedEventTextExtractor */
    private $serviceUnderTest;

    public function setUp()
    {
        $this->gameResult = \Mockery::mock(UserCreatedEvent::class);

        $this->serviceUnderTest = new UserCreatedEventTextExtractor();
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
        $extractedMessage = $this->serviceUnderTest->extractMessage($this->gameResult);

        $this->assertEquals(
            new TranslatableResource(UserCreatedEventTextExtractor::MESSAGE_KEY),
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
