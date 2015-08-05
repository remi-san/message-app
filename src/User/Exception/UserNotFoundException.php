<?php
namespace MessageApp\User\Exception;

class UserNotFoundException extends AppUserException
{
    /**
     * Constructor
     *
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(null, $message, $code, $previous);
    }
}
