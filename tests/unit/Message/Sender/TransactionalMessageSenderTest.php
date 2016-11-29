<?php

namespace MessageApp\Test\Message\Sender;

use MessageApp\Message;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\Message\Sender\TransactionalMessageSender;
use Mockery\Mock;
use RemiSan\TransactionManager\Exception\BeginException;
use RemiSan\TransactionManager\Exception\CommitException;
use RemiSan\TransactionManager\Exception\NoRunningTransactionException;

class TransactionalMessageSenderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Message */
    private $message;

    /** @var object */
    private $context;

    /** @var MessageSender | Mock */
    private $messageSender;

    /** @var TransactionalMessageSender */
    private $serviceUnderTest;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $this->message = \Mockery::mock(Message::class);
        $this->context = new \stdClass();

        $this->messageSender = \Mockery::mock(MessageSender::class);

        $this->serviceUnderTest = new TransactionalMessageSender($this->messageSender);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function beginTransactionShouldSucceedIfNoTransactionIsRunning()
    {
        $this->serviceUnderTest->beginTransaction();
    }

    /**
     * @test
     */
    public function beginTransactionShouldFailIfATransactionIsRunning()
    {
        $this->serviceUnderTest->beginTransaction();

        $this->setExpectedException(BeginException::class);

        $this->serviceUnderTest->beginTransaction();
    }

    /**
     * @test
     */
    public function commitShouldSucceedIfATransactionIsRunningAndMessageIsSent()
    {
        $this->serviceUnderTest->beginTransaction();

        $this->assertItWillSendMessage();

        $this->serviceUnderTest->send($this->message, $this->context);
        $this->serviceUnderTest->commit();
    }

    /**
     * @test
     */
    public function commitShouldFailIfATransactionIsRunningAndMessageIsNotSent()
    {
        $this->serviceUnderTest->beginTransaction();

        $this->givenMessageWillFailSending();

        $this->setExpectedException(CommitException::class);

        $this->serviceUnderTest->send($this->message, $this->context);
        $this->serviceUnderTest->commit();
    }

    /**
     * @test
     */
    public function commitShouldFailIfATransactionIsNotRunning()
    {
        $this->setExpectedException(NoRunningTransactionException::class);

        $this->serviceUnderTest->commit();
    }

    /**
     * @test
     */
    public function rollbackShouldSucceedIfATransactionIsRunning()
    {
        $this->serviceUnderTest->beginTransaction();

        $this->serviceUnderTest->rollback();
    }

    /**
     * @test
     */
    public function rollbackShouldFailIfATransactionIsNotRunning()
    {
        $this->setExpectedException(NoRunningTransactionException::class);

        $this->serviceUnderTest->rollback();
    }

    private function assertItWillSendMessage()
    {
        $this->messageSender
            ->shouldReceive('send')
            ->with($this->message, $this->context)
            ->once();
    }

    private function givenMessageWillFailSending()
    {
        $this->messageSender->shouldReceive('send')
            ->with($this->message, $this->context)
            ->andThrow(\Exception::class);
    }
}
