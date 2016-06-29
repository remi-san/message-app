<?php

namespace MessageApp\Test;

use MessageApp\Message\MessageFactory;
use MessageApp\Message\TextExtractor\MessageTextExtractor;
use MessageApp\User\ApplicationUser;
use MessageApp\User\UndefinedApplicationUser;
use RemiSan\Intl\ResourceTranslator;
use RemiSan\Intl\TranslatableResource;

class MessageFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageTextExtractor
     */
    private $extractor;

    /**
     * @var ResourceTranslator
     */
    private $resourceTranslator;

    public function setUp()
    {
        $this->extractor = \Mockery::mock(MessageTextExtractor::class);
        $this->resourceTranslator = \Mockery::mock(ResourceTranslator::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function withNoUsersItShouldReturnNull()
    {
        $factory = new MessageFactory($this->extractor, $this->resourceTranslator);

        $this->assertNull($factory->buildMessage([], null));
    }

    /**
     * @test
     */
    public function withNullUserItShouldReturnNull()
    {
        $factory = new MessageFactory($this->extractor, $this->resourceTranslator);

        $this->assertNull($factory->buildMessage([null], null));
    }

    /**
     * @test
     */
    public function withUndefinedApplicationUserItShouldReturnNull()
    {
        $factory = new MessageFactory($this->extractor, $this->resourceTranslator);

        $this->assertNull($factory->buildMessage([\Mockery::mock(UndefinedApplicationUser::class)], null));
    }

    /**
     * @test
     */
    public function withApplicationUserIfItCannotExtractMessageItShouldReturnNull()
    {
        $language = 'en';
        $user = \Mockery::mock(ApplicationUser::class);
        $object = new \stdClass();

        $factory = new MessageFactory($this->extractor, $this->resourceTranslator);

        $this->extractor
            ->shouldReceive('extractMessage')
            ->with($object)
            ->andReturn(null);

        $this->assertNull($factory->buildMessage([$user], $object, $language));
    }

    /**
     * @test
     */
    public function withApplicationUserIfLanguageIsPassedMessageItShouldReturnMessageTranslatedInRequiredLanguage()
    {
        $language = 'en';
        $user = \Mockery::mock(ApplicationUser::class);
        $object = new \stdClass();
        $translatedString = 'translated';
        $translatedMessage = new TranslatableResource($translatedString, ['key'=>'value']);
        $this->resourceTranslator
            ->shouldReceive('translate')
            ->with($language, $translatedMessage)
            ->andReturn($translatedString);

        $factory = new MessageFactory($this->extractor, $this->resourceTranslator);

        $this->extractor
            ->shouldReceive('extractMessage')
            ->with($object)
            ->andReturn($translatedMessage);

        $message = $factory->buildMessage([$user, null], $object, $language);

        $this->assertEquals([$user], $message->getUsers());
        $this->assertEquals($translatedString, $message->getMessage());
    }

    /**
     * @test
     */
    public function withApplicationUserIfLanguageIsNotPassedMessageItShouldReturnMessageTranslatedInUserLanguage()
    {
        $language = 'en';
        $user = \Mockery::mock(ApplicationUser::class, function ($u) use ($language) {
            $u->shouldReceive('getPreferredLanguage')->andReturn($language);
        });
        $object = new \stdClass();
        $translatedString = 'translated';
        $translatedMessage = new TranslatableResource($translatedString, ['key'=>'value']);
        $this->resourceTranslator
            ->shouldReceive('translate')
            ->with($language, $translatedMessage)
            ->andReturn($translatedString);

        $factory = new MessageFactory($this->extractor, $this->resourceTranslator);

        $this->extractor
            ->shouldReceive('extractMessage')
            ->with($object)
            ->andReturn($translatedMessage);

        $message = $factory->buildMessage([null, $user], $object);

        $this->assertEquals([$user], $message->getUsers());
        $this->assertEquals($translatedString, $message->getMessage());
    }
}
