<?php

namespace MessageApp\User\ThirdParty;

interface Account
{
    /**
     * @return Source
     */
    public function getSource();

    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getOriginalUser();
}
