<?php
namespace MessageApp;

interface ApplicationUser {

    /**
     * @return string|int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();
}