<?php
namespace MessageApp\Test\Mock;

use League\Tactician\CommandBus;
use MessageApp\Application\Command\ApplicationCommand;
use MessageApp\Application\Command\CreateUserCommand;
use MessageApp\Application\Message;
use MessageApp\Application\MessageSender;
use MessageApp\Application\Response\ApplicationResponse;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\ApplicationUser;
use MessageApp\ApplicationUserId;
use MessageApp\Parser\MessageParser;
use MessageApp\User\ApplicationUserManager;
use MessageApp\User\Repository\AppUserRepository;

trait MessageAppMocker
{
    /**
     * @param  ApplicationResponse $response
     * @return CommandBus
     */
    public function getCommandBus(ApplicationResponse $response = null)
    {
        $executor = \Mockery::mock('\\League\\Tactician\\CommandBus');
        if ($response) {
            $executor->shouldReceive('handle')->andReturn($response);
        }
        return $executor;
    }

    /**
     * @param  ApplicationUser $user
     * @param  string          $message
     * @return SendMessageResponse
     */
    public function getSendMessageResponse(ApplicationUser $user = null, $message = null)
    {
        $response = \Mockery::mock('\\MessageApp\\Application\\Response\\SendMessageResponse');
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
     * @return ApplicationCommand
     */
    public function getApplicationCommand(ApplicationUser $user = null)
    {
        $command = \Mockery::mock('\\MessageApp\\Application\\Command\\ApplicationCommand');
        $command->shouldReceive('getUser')->andReturn($user);
        return $command;
    }

    /**
     * @return ApplicationResponseHandler
     */
    public function getAppResponseHandler()
    {
        return \Mockery::mock('\\MessageApp\\Application\\Response\\Handler\\ApplicationResponseHandler');
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
     * @param  ApplicationCommand $command
     * @return MessageParser
     */
    public function getParser(ApplicationCommand $command = null)
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
     * @param  ApplicationUser $user
     * @return CreateUserCommand
     */
    public function getCreateUserCommand(ApplicationUser $user)
    {
        $command = \Mockery::mock('\\MessageApp\\Application\\Command\\CreateUserCommand');
        $command->shouldReceive('getUser')->andReturn($user);
        return $command;
    }
}
