<?php
namespace MessageApp\Application;

use MessageApp\Application\Command\ApplicationCommand;
use MessageApp\Application\Response\ApplicationResponse;

interface CommandExecutor {

    /**
     * Executes a command and returns a response
     *
     * @param  ApplicationCommand $command
     * @return ApplicationResponse
     */
    public function execute(ApplicationCommand $command);
}