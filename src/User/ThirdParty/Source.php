<?php

namespace MessageApp\User\ThirdParty;

interface Source
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function __toString();
}
