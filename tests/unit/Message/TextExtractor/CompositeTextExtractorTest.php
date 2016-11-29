<?php

namespace MessageApp\Test\Message\TextExtractor;

use Faker\Factory;
use MessageApp\Message\TextExtractor\CompositeTextExtractor;
use MessageApp\Message\TextExtractor\MessageTextExtractor;
use Mockery\Mock;

class CompositeTextExtractorTest extends \PHPUnit_Framework_TestCase
{
    /** @var object */
    private $event;

    /** @var string */
    private $message;

    /** @var MessageTextExtractor | Mock */
    private $subExOne;

    /** @var MessageTextExtractor | Mock */
    private $subExTwo;

    /** @var CompositeTextExtractor */
    private $serviceUnderTest;

    public function setUp()
    {
        $faker = Factory::create();

        $this->event = new \stdClass();
        $this->message = $faker->word;
        $this->subExOne = \Mockery::mock(MessageTextExtractor::class);
        $this->subExTwo = \Mockery::mock(MessageTextExtractor::class);

        $this->serviceUnderTest = new CompositeTextExtractor();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldExtractTheMessageTheFirstSubExtractorReturns()
    {
        $this->givenItHasSubExtractors();
        $this->givenFirstSubExtractorCannotExtractMessage();
        $this->givenSecondSubExtractorCannotExtractMessage();

        $extractedMessage = $this->serviceUnderTest->extractMessage($this->event);

        $this->assertEquals($this->message, $extractedMessage);
    }

    /**
     * @test
     */
    public function itShouldReturnNothingIfNoSubExtractorCanExtractTheMessage()
    {
        $extractedMessage = $this->serviceUnderTest->extractMessage(null);

        $this->assertNull($extractedMessage);
    }

    private function givenItHasSubExtractors()
    {
        $this->serviceUnderTest->addExtractor($this->subExOne);
        $this->serviceUnderTest->addExtractor($this->subExTwo);
    }

    private function givenFirstSubExtractorCannotExtractMessage()
    {
        $this->subExOne->shouldReceive('extractMessage')->with($this->event)->andReturn(null);
    }

    private function givenSecondSubExtractorCannotExtractMessage()
    {
        $this->subExTwo->shouldReceive('extractMessage')->with($this->event)->andReturn($this->message);
    }
}
