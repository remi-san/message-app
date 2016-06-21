<?php

namespace MessageApp\Test;

use MessageApp\Message\TextExtractor\MessageParserExceptionTextExtractor;
use MessageApp\Parser\Exception\MessageParserException;
use RemiSan\Intl\TranslatableResource;

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

        $extractedMessage = $extractor->extractMessage($exception);

        $this->assertEquals(new TranslatableResource($message), $extractedMessage);
    }

    /**
     * @test
     */
    public function testWithUnknownObject()
    {
        $extractor = new MessageParserExceptionTextExtractor();

        $extractedMessage = $extractor->extractMessage(null);

        $this->assertNull($extractedMessage);
    }
}
