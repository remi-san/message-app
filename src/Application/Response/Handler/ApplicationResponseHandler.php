<?php
namespace MessageApp\Application\Response\Handler;

use MessageApp\Application\Response\ApplicationResponse;

interface ApplicationResponseHandler {

    /**
     * Handle response
     *
     * @param  ApplicationResponse $response
     * @param  object              $context
     * @return void
     */
    public function handle(ApplicationResponse $response = null, $context = null);
} 