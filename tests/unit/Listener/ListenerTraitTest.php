<?php

namespace MessageApp\Test\Listener;

use League\Event\Event;
use MessageApp\Test\Listener\Mock\TestableListenerTrait;
use MessageApp\Test\Listener\Mock\TestEvent;

class ListenerTraitTest extends \PHPUnit_Framework_TestCase
{
    /** @var TestEvent */
    private $event;

    /** @var TestableListenerTrait */
    private $serviceUnderTest;

    /**
     * Init
     */
    public function setUp()
    {
        $this->event = new TestEvent();

        $this->serviceUnderTest = new TestableListenerTrait();
    }

    /**
     * Close
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldBeAListener()
    {
        $this->assertTrue($this->serviceUnderTest->isListener($this->serviceUnderTest));
    }

    /**
     * @test
     */
    public function itShouldHandleEvent()
    {
        $this->serviceUnderTest->handle($this->event);

        $this->assertEquals($this->event, $this->serviceUnderTest->receivedEvent);
    }

    /**
     * @test
     */
    public function itShouldNotHandleEvent()
    {
        $this->serviceUnderTest->handle(new Event('test'));

        $this->assertNull($this->serviceUnderTest->receivedEvent);
    }
}
