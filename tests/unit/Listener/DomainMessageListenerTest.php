<?php
namespace MessageApp\Test\Listener;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\Tools\Metadata\Context\ContextEnricher;
use League\Event\EventInterface;
use MessageApp\Listener\DomainMessageListener;
use MessageApp\Listener\MessageEventHandler;
use RemiSan\Context\Context;

class DomainMessageListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageEventHandler
     */
    private $handler;

    public function setUp()
    {
        $this->handler = \Mockery::mock(MessageEventHandler::class);
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
        $event = \Mockery::mock(EventInterface::class);
        $context = \Mockery::mock(Context::class);
        $metadata = \Mockery::mock(Metadata::class, function ($metadata) use ($context) {
            $metadata->shouldReceive('serialize')->andReturn([ContextEnricher::CONTEXT => $context]);
        });
        $message = DomainMessage::recordNow('id', 0, $metadata, $event);

        $this->handler->shouldReceive('handle')->with($event, $context)->once();

        $listener = new DomainMessageListener($this->handler);
        $listener->handle($message);
    }

    /**
     * @test
     */
    public function itShouldDeferHandlingToInnerHandlerAfterRetrievingEventAndNullContext()
    {
        $event = \Mockery::mock(EventInterface::class);
        $metadata = \Mockery::mock(Metadata::class, function ($metadata) {
            $metadata->shouldReceive('serialize')->andReturn([]);
        });
        $message = DomainMessage::recordNow('id', 0, $metadata, $event);

        $this->handler->shouldReceive('handle')->with($event, null)->once();

        $listener = new DomainMessageListener($this->handler);
        $listener->handle($message);
    }
}
