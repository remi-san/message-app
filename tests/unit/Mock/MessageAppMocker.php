<?php
namespace MessageApp\Test\Mock;

use League\Tactician\CommandBus;
use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Command\CreateUserCommand;
use MessageApp\Message;
use MessageApp\Message\DefaultMessage;
use MessageApp\Message\Sender\MessageSender;
use MessageApp\Parser\MessageParser;
use MessageApp\User\ApplicationUser;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\Manager\ApplicationUserManager;
use MessageApp\User\Store\ApplicationUserStore;

trait MessageAppMocker
{
    /**
     * @param  Message $message
     * @return CommandBus
     */
    public function getCommandBus(Message $message = null)
    {
        $executor = \Mockery::mock('\\League\\Tactician\\CommandBus');
        if ($message) {
            $executor->shouldReceive('handle')->andReturn($message);
        }
        return $executor;
    }

    /**
     * @param  ApplicationUser $user
     * @param  string          $message
     * @return DefaultMessage
     */
    public function getSendMessageResponse(ApplicationUser $user = null, $message = null)
    {
        $response = \Mockery::mock('\\MessageApp\\Message\\DefaultMessage');
        $response->shouldReceive('getUser')->andReturn($user);
        $response->shouldReceive('getMessage')->andReturn($message);
        return $response;
    }

    /**
     * @param  int    $id
     * @return ApplicationUserId
     */
    public function getApplicationUserId($id)
    {
        $appUser = \Mockery::mock('\\MessageApp\\User\\ApplicationUserId');
        $appUser->shouldReceive('getId')->andReturn((string)$id);
        $appUser->shouldReceive('__toString')->andReturn((string)$id);
        return $appUser;
    }

    /**
     * @param  ApplicationUserId $id
     * @param  string            $name
     * @return ApplicationUser
     */
    public function getApplicationUser(ApplicationUserId $id, $name)
    {
        $appUser = \Mockery::mock('\\MessageApp\\User\\ApplicationUser');
        $appUser->shouldReceive('getId')->andReturn($id);
        $appUser->shouldReceive('getName')->andReturn($name);
        return $appUser;
    }

    /**
     * @param  ApplicationUser $user
     * @return NamedCommand
     */
    public function getApplicationCommand(ApplicationUser $user = null)
    {
        $command = \Mockery::mock('\\League\Tactician\Plugins\NamedCommand\NamedCommand');
        $command->shouldReceive('getUser')->andReturn($user);
        return $command;
    }

    /**
     * @return MessageSender
     */
    public function getMessageSender()
    {
        return \Mockery::mock('\\MessageApp\\Message\\Sender\\MessageSender');
    }

    /**
     * @param  string          $text
     * @param  ApplicationUser $user
     * @return Message
     */
    public function getMessage($text, ApplicationUser $user)
    {
        $message = \Mockery::mock('\\MessageApp\\Message');
        $message->shouldReceive('getMessage')->andReturn($text);
        $message->shouldReceive('getUser')->andReturn($user);

        return $message;
    }

    /**
     * @param  NamedCommand $command
     * @return MessageParser
     */
    public function getParser(NamedCommand $command = null)
    {
        $parser = \Mockery::mock('\\MessageApp\\Parser\\MessageParser');
        $parser->shouldReceive('parse')->andReturn($command);
        return $parser;
    }

    /**
     * @param  ApplicationUser $user
     * @return ApplicationUserManager
     */
    public function getUserManager(ApplicationUser $user)
    {
        $manager = \Mockery::mock('\\MessageApp\\User\\Manager\\ApplicationUserManager');
        $manager->shouldReceive('get')->andReturn($user);
        return $manager;
    }

    /**
     * @return \MessageApp\User\Store\ApplicationUserStore
     */
    public function getUserRepository()
    {
        return \Mockery::mock('\\MessageApp\\User\\Store\\ApplicationUserStore');
    }

    /**
     * @param  object $user
     * @return CreateUserCommand
     */
    public function getCreateUserCommand($user)
    {
        $command = \Mockery::mock('\\MessageApp\\Command\\CreateUserCommand');
        $command->shouldReceive('getOriginalUser')->andReturn($user);
        return $command;
    }
}
