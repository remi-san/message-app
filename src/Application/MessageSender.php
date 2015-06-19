<?php
namespace MessageApp\Application;

use MessageApp\ApplicationUser;

interface MessageSender {

    /**
     * Send a message
     *
     * @param  Message $message
     * @param  object  $context
     * @return void
     */
    public function send(Message $message, $context);

    /**
     * Register the user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function register(ApplicationUser $user);

    /**
     * Unregister the user
     *
     * @param  ApplicationUser $user
     * @return void
     */
    public function unregister(ApplicationUser $user);
} 