<?php
namespace MessageApp;

interface ApplicationUser
{

    /**
     * Returns the id
     *
     * @return string|int
     */
    public function getId();

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName();
}