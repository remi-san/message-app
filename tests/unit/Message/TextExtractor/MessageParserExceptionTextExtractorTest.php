<?php

namespace MessageApp\Test\Message\TextExtractor;

use Faker\Factory;
use MessageApp\Message\TextExtractor\MessageParserExceptionTextExtractor;
use MessageApp\Parser\Exception\MessageParserException;
use RemiSan\Intl\TranslatableResource;

class MessageParserExceptionTextExtractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $code;

    /** @var string */
    private $message;

    /** @var MessageParserException */
    private $exception;

    /** @var MessageParserExceptionTextExtractor */
    private $serviceUnderTest;

    public function setUp()
    {
        $faker = Factory::create();

        $this->code = $faker->word;
        $this->message = $faker->sentence;
        $this->exception = new MessageParserException(null, $this->code, $this->message);

        $this->serviceUnderTest = new MessageParserExceptionTextExtractor();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldExtractMessageFromException()
    {
        $extractedMessage = $this->serviceUnderTest->extractMessage($this->exception);

        $this->assertEquals(new TranslatableResource($this->code), $extractedMessage);
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
