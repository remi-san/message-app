<?php

namespace MessageApp\Test\Message\TextExtractor;

use MessageApp\Event\UserEvent;
use MessageApp\Message\TextExtractor\MessageTextExtractor;
use MessageApp\Message\TextExtractor\UserEventTextExtractor;
use Mockery\Mock;

class UserEventExceptionTextExtractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $message;

    /** @var UserEvent */
    private $gameResult;

    /** @var MessageTextExtractor | Mock */
    private $gameResultExtractor;

    /** @var UserEventTextExtractor */
    private $extractor;

    public function setUp()
    {
        $this->message = 'test-message';
        $this->gameResult = \Mockery::mock(UserEvent::class);
        $this->gameResultExtractor = \Mockery::mock(MessageTextExtractor::class);

        $this->extractor = new UserEventTextExtractor([$this->gameResultExtractor]);
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
        $this->givenGameResultExtractorCanExtractMessage();

        $extractedMessage = $this->extractor->extractMessage($this->gameResult);

        $this->assertEquals($this->message, $extractedMessage);
    }

    /**
     * @test
     */
    public function itShouldNotExtractMessageWithNoGameResultExtractors()
    {
        $this->givenThereAreNoGameResultExtractors();

        $extractedMessage = $this->extractor->extractMessage($this->gameResult);

        $this->assertNull($extractedMessage);
    }

    /**
     * @test
     */
    public function itShouldNotExtractMessageWithNullEvent()
    {
        $extractedMessage = $this->extractor->extractMessage(null);

        $this->assertNull($extractedMessage);
    }

    private function givenGameResultExtractorCanExtractMessage()
    {
        $this->gameResultExtractor->shouldReceive('extractMessage')
            ->with($this->gameResult)
            ->andReturn($this->message)
            ->once();
    }

    private function givenThereAreNoGameResultExtractors()
    {
        $this->extractor = new UserEventTextExtractor();
    }
}
