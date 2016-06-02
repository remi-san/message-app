<?php

namespace MessageApp\Message\Sender;

use MessageApp\Message;
use RemiSan\TransactionManager\Exception\BeginException;
use RemiSan\TransactionManager\Exception\CommitException;
use RemiSan\TransactionManager\Exception\NoRunningTransactionException;
use RemiSan\TransactionManager\Exception\RollbackException;
use RemiSan\TransactionManager\Transactional;

class TransactionalMessageSender implements MessageSender, Transactional
{
    /**
     * @var MessageSender
     */
    private $messageSender;

    /**
     * @var Message[]
     */
    private $messages;

    /**
     * @var boolean
     */
    private $transactionRunning;

    /**
     * @param MessageSender $messageSender
     */
    public function __construct(MessageSender $messageSender)
    {
        $this->messageSender = $messageSender;
        $this->messages = [];
        $this->transactionRunning = false;
    }

    /**
     * Send a message
     *
     * @param  Message $message
     * @param  object $context
     * @return void
     */
    public function send(Message $message, $context)
    {
        $this->messages[] = [ $message, $context ];
    }

    /**
     * Open transaction.
     *
     * @throws BeginException
     */
    public function beginTransaction()
    {
        if ($this->transactionRunning) {
            throw new BeginException('Transaction already running');
        }

        $this->messages = [];
        $this->transactionRunning = true;
    }

    /**
     * Commit transaction.
     *
     * @throws CommitException
     * @throws NoRunningTransactionException
     */
    public function commit()
    {
        if (!$this->transactionRunning) {
            throw new NoRunningTransactionException();
        }

        try {
            foreach ($this->messages as $message) {
                $this->messageSender->send($message[0], $message[1]);
            }
        } catch (\Exception $e) {
            throw new CommitException('Error during commit', 0, $e);
        }

        $this->messages = [];
        $this->transactionRunning = false;
    }

    /**
     * Rollback transaction.
     *
     * @throws RollbackException
     * @throws NoRunningTransactionException
     */
    public function rollback()
    {
        if (!$this->transactionRunning) {
            throw new NoRunningTransactionException();
        }

        $this->messages = [];
        $this->transactionRunning = false;
    }
}
