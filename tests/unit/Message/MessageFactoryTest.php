<?php

namespace MessageApp\Test\Message;

use Faker\Factory;
use MessageApp\Message\MessageFactory;
use MessageApp\Message\TextExtractor\MessageTextExtractor;
use MessageApp\User\ApplicationUser;
use Mockery\Mock;
use RemiSan\Intl\ResourceTranslator;
use RemiSan\Intl\TranslatableResource;

class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $language;

    /** @var ApplicationUser | Mock */
    private $user;

    /** @var object */
    private $object;

    /** @var string */
    private $untranslatedString;

    /** @var string */
    private $translatedString;

    /** @var TranslatableResource */
    private $translatedMessage;

    /** @var MessageTextExtractor | Mock */
    private $extractor;

    /** @var ResourceTranslator | Mock */
    private $resourceTranslator;

    /** @var MessageFactory */
    private $serviceUnderTest;

    public function setUp()
    {
        $faker = Factory::create();

        $this->language = $faker->countryISOAlpha3;
        $this->user = \Mockery::mock(ApplicationUser::class);
        $this->object = new \stdClass();
        $this->untranslatedString = $faker->sentence;
        $this->translatedString = $faker->sentence;
        $this->translatedMessage = new TranslatableResource(
            $this->untranslatedString,
            [ $faker->word => $faker->word ]
        );

        $this->extractor = \Mockery::mock(MessageTextExtractor::class);
        $this->resourceTranslator = \Mockery::mock(ResourceTranslator::class);

        $this->serviceUnderTest = new MessageFactory($this->extractor, $this->resourceTranslator);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldNotBuildMessageWithNoUser()
    {
        $message = $this->serviceUnderTest->buildMessage([], null);

        $this->assertNull($message);
    }

    /**
     * @test
     */
    public function itShouldNotBuildMessageWithNullUser()
    {
        $message = $this->serviceUnderTest->buildMessage([null], null);

        $this->assertNull($message);
    }

    /**
     * @test
     */
    public function itShouldNotBuildMessageIfItCannotExtractMessage()
    {
        $this->givenItCanNotExtractMessage();

        $message = $this->serviceUnderTest->buildMessage([$this->user], $this->object, $this->language);

        $this->assertNull($message);
    }

    /**
     * @test
     */
    public function itShouldBuildMessageWithoutTranslationIfTranslationFails()
    {
        $this->givenItCanExtractMessage();
        $this->givenTranslatorWillFailTranslating();

        $message = $this->serviceUnderTest->buildMessage([$this->user, null], $this->object, $this->language);

        $this->assertEquals([$this->user], $message->getUsers());
        $this->assertEquals($this->untranslatedString, $message->getMessage());
    }

    /**
     * @test
     */
    public function itShouldBuildMessageInRequiredLanguageIfLanguageIsPassed()
    {
        $this->givenItCanExtractMessage();
        $this->givenTranslatorWillTranslate();

        $message = $this->serviceUnderTest->buildMessage([$this->user, null], $this->object, $this->language);

        $this->assertEquals([$this->user], $message->getUsers());
        $this->assertEquals($this->translatedString, $message->getMessage());
    }

    /**
     * @test
     */
    public function itShouldBuildMessageInUserLanguageIfLanguageIsNotPassed()
    {
        $this->givenUserAsAPreferredLanguage();
        $this->givenItCanExtractMessage();
        $this->givenTranslatorWillTranslate();

        $message = $this->serviceUnderTest->buildMessage([null, $this->user], $this->object);

        $this->assertEquals([$this->user], $message->getUsers());
        $this->assertEquals($this->translatedString, $message->getMessage());
    }

    private function givenItCanExtractMessage()
    {
        $this->extractor
            ->shouldReceive('extractMessage')
            ->with($this->object)
            ->andReturn($this->translatedMessage);
    }

    private function givenItCanNotExtractMessage()
    {
        $this->extractor
            ->shouldReceive('extractMessage')
            ->with($this->object)
            ->andReturn(null);
    }

    private function givenTranslatorWillTranslate()
    {
        $this->resourceTranslator
            ->shouldReceive('translate')
            ->with($this->language, $this->translatedMessage)
            ->andReturn($this->translatedString);
    }

    private function givenTranslatorWillFailTranslating()
    {
        $this->resourceTranslator
            ->shouldReceive('translate')
            ->with($this->language, $this->translatedMessage)
            ->andThrow(\IntlException::class);
    }

    private function givenUserAsAPreferredLanguage()
    {
        $this->user->shouldReceive('getPreferredLanguage')->andReturn($this->language);
    }
}
