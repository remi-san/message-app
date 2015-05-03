<?php
namespace MessageApp\Test\Mock;

use MessageApp\Application\CommandExecutor;
use MessageApp\Application\Response\ApplicationResponse;
use MessageApp\Application\Response\Handler\ApplicationResponseHandler;
use MessageApp\Application\Response\SendMessageResponse;
use MessageApp\ApplicationUser;

trait MessageAppMocker {

    /**
     * @param  ApplicationResponse $response
     * @return CommandExecutor
     */
    public function getExecutor(ApplicationResponse $response = null) {
        $executor = \Mockery::mock('\\MessageApp\\Application\\CommandExecutor');
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
     * @return ApplicationResponseHandler
     */
    public function getAppResponseHandler()
    {
        return \Mockery::mock('\\MessageApp\\Application\\Response\\Handler\\ApplicationResponseHandler');
    }
} 