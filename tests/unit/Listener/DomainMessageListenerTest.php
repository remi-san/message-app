<?php
namespace MessageApp\Test\Listener;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\Tools\Metadata\Context\ContextEnricher;
use League\Event\EventInterface;
use MessageApp\Listener\DomainMessageListener;
use MessageApp\Listener\MessageEventHandler;
use Mockery\Mock;
use RemiSan\Context\Context;

class DomainMessageListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var EventInterface */
    private $event;

    /** @var Context */
    private $context;

    /** @var Metadata | Mock */
    private $metadata;

    /** @var DomainMessage */
    private $message;

    /** @var MessageEventHandler | Mock */
    private $handler;

    /** @var DomainMessageListener */
    private $serviceUnderTest;

    public function setUp()
    {
        $this->event = \Mockery::mock(EventInterface::class);
        $this->context = \Mockery::mock(Context::class);
        $this->metadata = \Mockery::mock(Metadata::class);

        $this->message = DomainMessage::recordNow('id', 0, $this->metadata, $this->event);

        $this->handler = \Mockery::mock(MessageEventHandler::class);

        $this->serviceUnderTest = new DomainMessageListener($this->handler);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldDeferHandlingToInnerHandlerAfterRetrievingEventAndContext()
    {
        $this->givenMetadataContainsContext();

        $this->assertHandlerWillHandleEventWithContext();

        $this->serviceUnderTest->handle($this->message);
    }

    /**
     * @test
     */
    public function itShouldDeferHandlingToInnerHandlerAfterRetrievingEventAndNullContext()
    {
        $this->givenMetadataContainsNothing();

        $this->assertHandlerWillHandleEventWithoutContext();

        $this->serviceUnderTest->handle($this->message);
    }

    private function givenMetadataContainsContext()
    {
        $this->metadata->shouldReceive('serialize')->andReturn([ContextEnricher::CONTEXT => $this->context]);
    }

    private function givenMetadataContainsNothing()
    {
        $this->metadata->shouldReceive('serialize')->andReturn([]);
    }

    private function assertHandlerWillHandleEventWithContext()
    {
        $this->handler->shouldReceive('handle')->with($this->event, $this->context)->once();
    }

    private function assertHandlerWillHandleEventWithoutContext()
    {
        $this->handler->shouldReceive('handle')->with($this->event, null)->once();
    }
}
