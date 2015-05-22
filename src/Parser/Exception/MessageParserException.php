<?php
namespace MessageApp\Parser\Exception;

use Exception;
use MessageApp\ApplicationUser;

class MessageParserException extends \Exception {

    /**
     * @var ApplicationUser
     */
    protected $user;

    /**
     * Constructor
     *
     * @param ApplicationUser $user
     * @param string          $message
     * @param int             $code
     * @param \Exception      $previous
     */
    public function __construct(ApplicationUser $user, $message = '', $code = 0, \Exception $previous = null)
    {
        $this->user = $user;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns the user
     *
     * @return ApplicationUser
     */
    public function getUser()
    {
        return $this->user;
    }
} 