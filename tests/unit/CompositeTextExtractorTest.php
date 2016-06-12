<?php

namespace MessageApp\Test;

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
        $language = 'en';
        $subExOne = \Mockery::mock(MessageTextExtractor::class, function ($extractor) use ($event, $language) {
            $extractor->shouldReceive('extractMessage')->with($event, $language)->andReturn(null);
        });
        $subExTwo = \Mockery::mock(MessageTextExtractor::class, function ($extractor) use ($event, $language, $message) {
            $extractor->shouldReceive('extractMessage')->with($event, $language)->andReturn($message);
        });

        $extractor = new CompositeTextExtractor();
        $extractor->addExtractor($subExOne);
        $extractor->addExtractor($subExTwo);

        $extractedMessage = $extractor->extractMessage($event, $language);

        $this->assertEquals($message, $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithoutSubExtractorSuccess()
    {
        $extractor = new CompositeTextExtractor();

        $extractedMessage = $extractor->extractMessage(null, 'en');

        $this->assertNull($extractedMessage);
    }
}
