<?php
namespace MessageApp\Test\Mock;

use Command\CommandExecutor;
use MessageApp\Application\Command\ApplicationCommand;
use MessageApp\Application\Message;
use MessageApp\Application\MessageSender;
use MessageApp\Application\Response\ApplicationResponse;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\ApplicationUser;
use MessageApp\Parser\MessageParser;
use MessageApp\User\ApplicationUserManager;

trait MessageAppMocker {

    /**
     * @param  ApplicationResponse $response
     * @return \Command\CommandExecutor
     */
    public function getExecutor(ApplicationResponse $response = null) {
        $executor = \Mockery::mock('\\Command\\CommandExecutor');
        if ($response) {
            $executor->shouldReceive('execute')->andReturn($response);
        }
        return $executor;
    }

    /**
     * @param  ApplicationUser $user
     * @param  string $message
     * @return SendMessageResponse
     */
    public function getSendMessageResponse(ApplicationUser $user = null, $message = null) {
        $response = \Mockery::mock('\\MessageApp\\Application\\Response\\SendMessageResponse');
        $response->shouldReceive('getUser')->andReturn($user);
        $response->shouldReceive('getMessage')->andReturn($message);
        return $response;
    }

    /**
     * @param  int    $id
     * @param  string $name
     * @return ApplicationUser
     */
    public function getApplicationUser($id, $name)
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
    public function getParser(ApplicationCommand $command = null){
        $parser = \Mockery::mock('\\MessageApp\\Parser\\MessageParser');
        $parser->shouldReceive('parse')->andReturn($command);
        return $parser;
    }

    /**
     * @param  ApplicationUser $user
     * @return ApplicationUserManager
     */
    public function getUserManager(ApplicationUser $user) {
        $manager = \Mockery::mock('\\MessageApp\\User\\ApplicationUserManager');
        $manager->shouldReceive('get')->andReturn($user);
        return $manager;
    }
} 