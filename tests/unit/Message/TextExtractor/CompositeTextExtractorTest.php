<?php

namespace MessageApp\Test\Message\TextExtractor;

use MessageApp\Message\TextExtractor\CompositeTextExtractor;
use MessageApp\Message\TextExtractor\MessageTextExtractor;

class CompositeTextExtractorTest extends \PHPUnit_Framework_TestCase
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
    public function testWithSubExtractorSuccess()
    {
        $event = new \stdClass();
        $message = 'test-message';
        $subExOne = \Mockery::mock(MessageTextExtractor::class, function ($extractor) use ($event) {
            $extractor->shouldReceive('extractMessage')->with($event)->andReturn(null);
        });
        $subExTwo = \Mockery::mock(MessageTextExtractor::class, function ($extractor) use ($event, $message) {
            $extractor->shouldReceive('extractMessage')->with($event)->andReturn($message);
        });

        $extractor = new CompositeTextExtractor();
        $extractor->addExtractor($subExOne);
        $extractor->addExtractor($subExTwo);

        $extractedMessage = $extractor->extractMessage($event);

        $this->assertEquals($message, $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithoutSubExtractorSuccess()
    {
        $extractor = new CompositeTextExtractor();

        $extractedMessage = $extractor->extractMessage(null);

        $this->assertNull($extractedMessage);
    }
}
