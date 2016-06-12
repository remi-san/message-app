<?php

namespace MessageApp\Test;

use MessageApp\Message\TextExtractor\MessageParserExceptionTextExtractor;
use MessageApp\Parser\Exception\MessageParserException;

class MessageParserExceptionTextExtractorTest extends \PHPUnit_Framework_TestCase
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
    public function testWithMessageParserException()
    {
        $message = 'test-message';
        $exception = new MessageParserException(null, null, $message);

        $extractor = new MessageParserExceptionTextExtractor();

        $extractedMessage = $extractor->extractMessage($exception, 'en');

        $this->assertEquals($message, $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new MessageParserExceptionTextExtractor();

        $extractedMessage = $extractor->extractMessage(null, 'en');

        $this->assertNull($extractedMessage);
    }
}
