<?php
namespace MessageApp\Parser;

use MessageApp\User\ApplicationUserId;

interface ParsingUser
{
    /**
     * Returns the id
     *
     * @return ApplicationUserId
     */
    public function getId();

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the preferred language
     *
     * @return string
     */
    public function getPreferredLanguage();

    /**
     * Is the user defined
     *
     * @return boolean
     */
    public function isDefined();
}
