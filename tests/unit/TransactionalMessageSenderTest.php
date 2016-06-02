<?php

namespace MessageApp\Test;

use MessageApp\Message;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\Message\Sender\TransactionalMessageSender;
use RemiSan\TransactionManager\Exception\BeginException;
use RemiSan\TransactionManager\Exception\CommitException;
use RemiSan\TransactionManager\Exception\NoRunningTransactionException;

class TransactionalMessageSenderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * Init the mocks
     */
    public function setUp()
    {
        $this->messageSender = \Mockery::mock(MessageSender::class);
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
        $sender = new TransactionalMessageSender($this->messageSender);
        $sender->beginTransaction();
    }

    /**
     * @test
     */
    public function beginTransactionShouldFailIfATransactionIsRunning()
    {
        $sender = new TransactionalMessageSender($this->messageSender);
        $sender->beginTransaction();

        $this->setExpectedException(BeginException::class);

        $sender->beginTransaction();
    }

    /**
     * @test
     */
    public function commitShouldSucceedIfATransactionIsRunningAndMessageIsSent()
    {
        $message = \Mockery::mock(Message::class);
        $context = [ 'context' ];

        $sender = new TransactionalMessageSender($this->messageSender);
        $sender->beginTransaction();

        $this->messageSender->shouldReceive('send')->with($message, $context)->once();

        $sender->send($message, $context);
        $sender->commit();
    }

    /**
     * @test
     */
    public function commitShouldFailIfATransactionIsRunningAndMessageIsNotSent()
    {
        $message = \Mockery::mock(Message::class);
        $context = [ 'context' ];

        $sender = new TransactionalMessageSender($this->messageSender);
        $sender->beginTransaction();

        $this->messageSender->shouldReceive('send')
            ->with($message, $context)
            ->andThrow(\Exception::class);

        $this->setExpectedException(CommitException::class);

        $sender->send($message, $context);
        $sender->commit();
    }

    /**
     * @test
     */
    public function commitShouldFailIfATransactionIsNotRunning()
    {
        $sender = new TransactionalMessageSender($this->messageSender);

        $this->setExpectedException(NoRunningTransactionException::class);

        $sender->commit();
    }

    /**
     * @test
     */
    public function rollbackShouldSucceedIfATransactionIsRunning()
    {
        $sender = new TransactionalMessageSender($this->messageSender);
        $sender->beginTransaction();

        $sender->rollback();
    }

    /**
     * @test
     */
    public function rollbackShouldFailIfATransactionIsNotRunning()
    {
        $sender = new TransactionalMessageSender($this->messageSender);

        $this->setExpectedException(NoRunningTransactionException::class);

        $sender->rollback();
    }
}
