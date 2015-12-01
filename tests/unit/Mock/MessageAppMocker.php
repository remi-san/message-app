<?php
namespace MessageApp\Test\Mock;

use League\Tactician\CommandBus;
use League\Tactician\Plugins\NamedCommand\NamedCommand;
use MessageApp\Application\Command\CreateUserCommand;
use MessageApp\Application\Message;
use MessageApp\Application\Message\Handler\MessageHandler;
use MessageApp\Application\Message\SendMessageResponse;
use MessageApp\Application\MessageSender;
use MessageApp\ApplicationUser;
use MessageApp\ApplicationUserId;
use MessageApp\Parser\MessageParser;
use MessageApp\User\ApplicationUserManager;
use MessageApp\User\Repository\AppUserRepository;

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
     * @return \MessageApp\Application\Message\SendMessageResponse
     */
    public function getSendMessageResponse(ApplicationUser $user = null, $message = null)
    {
        $response = \Mockery::mock('\\MessageApp\\Application\\Message\\SendMessageResponse');
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
        $appUser = \Mockery::mock('\\MessageApp\\ApplicationUserId');
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
        $appUser = \Mockery::mock('\\MessageApp\\ApplicationUser');
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
     * @return \MessageApp\Application\Message\Handler\MessageHandler
     */
    public function getAppResponseHandler()
    {
        return \Mockery::mock('\\MessageApp\\Application\\Message\\Handler\\MessageHandler');
    }

    /**
     * @return MessageSender
     */
    public function getMessageSender()
    {
        return \Mockery::mock('\\MessageApp\\Application\\MessageSender');
    }

    /**
     * @param  string          $text
     * @param  ApplicationUser $user
     * @return Message
     */
    public function getMessage($text, ApplicationUser $user)
    {
        $message = \Mockery::mock('\\MessageApp\\Application\\Message');
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
        $manager = \Mockery::mock('\\MessageApp\\User\\ApplicationUserManager');
        $manager->shouldReceive('get')->andReturn($user);
        return $manager;
    }

    /**
     * @return AppUserRepository
     */
    public function getUserRepository()
    {
        return \Mockery::mock('\\MessageApp\\User\\Repository\\AppUserRepository');
    }

    /**
     * @param  object $user
     * @return CreateUserCommand
     */
    public function getCreateUserCommand($user)
    {
        $command = \Mockery::mock('\\MessageApp\\Application\\Command\\CreateUserCommand');
        $command->shouldReceive('getOriginalUser')->andReturn($user);
        return $command;
    }
}
