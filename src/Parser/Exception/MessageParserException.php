<?php

namespace MessageApp\Parser\Exception;

use MessageApp\Exception\MessageAppException;
use MessageApp\User\ApplicationUser;

class MessageParserException extends MessageAppException
{
    const JOIN_MULTIPLE_USERS = 'game.parser.exception.join.multiple-users';
    const JOIN_UNREGISTERED_USER = 'game.parser.exception.join.unregistered-users';
    const JOIN_NO_GAME = 'game.parser.exception.join.no-game';
    const JOIN_YOURSELF = 'game.parser.exception.join.yourself';
    const JOIN_GAME_RUNNING = 'game.parser.exception.join.game-running';
    const START_NOT_IN = 'game.parser.exception.start.not-in';
    const LEAVE_NOT_IN = 'game.parser.exception.leave.not-in';
    const CREATE_MULTIPLE = 'game.parser.exception.create.multiple';
    const GAME_NOT_FOUND = 'game.parser.exception.game-not-found';
    const INVALID_USER = 'parser.exception.invalid-user';
    const PARSE_ERROR = 'parser.exception.parse-error';

    /**
     * @var string
     */
    private $codeName;

    /**
     * Constructor
     *
     * @param ApplicationUser $user
     * @param string          $codeName
     * @param string          $message
     * @param int             $code
     * @param \Exception      $previous
     */
    public function __construct(
        ApplicationUser $user = null,
        $codeName = null,
        $message = '',
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($user, $message, $code, $previous);
        $this->codeName = $codeName;
    }

    /**
     * @return string
     */
    public function getCodeName()
    {
        return $this->codeName;
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotJoinMultipleUsers(ApplicationUser $user)
    {
        return new self($user, self::JOIN_MULTIPLE_USERS, 'You have to provide one (and only one) user to join!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotJoinUnregisteredUser(ApplicationUser $user)
    {
        return new self($user, self::JOIN_UNREGISTERED_USER, 'You cannot join a user who is not registered!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotJoinUserWithoutAGame(ApplicationUser $user)
    {
        return new self($user, self::JOIN_NO_GAME, 'You cannot join a player with no game!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotJoinYourself(ApplicationUser $user)
    {
        return new self($user, self::JOIN_YOURSELF, 'You cannot join yourself!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotJoinIfGameAlreadyRunning(ApplicationUser $user)
    {
        return new self($user, self::JOIN_GAME_RUNNING, 'You already have a game running!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotParseMessage(ApplicationUser $user)
    {
        return new self($user, self::PARSE_ERROR, 'Could not parse message!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotStartGameUserIsNotIn(ApplicationUser $user)
    {
        return new self($user, self::START_NOT_IN, 'You cannot start a game you are not in!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotLeaveGameUserIsNotIn(ApplicationUser $user)
    {
        return new self($user, self::LEAVE_NOT_IN, 'You cannot leave a game you are not in!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotFindGameForUser(ApplicationUser $user)
    {
        return new self(
            $user,
            self::GAME_NOT_FOUND,
            'The game or associated player was not found. Try starting/joining a game first.'
        );
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function cannotCreateMultipleGames(ApplicationUser $user)
    {
        return new self($user, self::CREATE_MULTIPLE, 'You already have a game running!');
    }

    /**
     * @param ApplicationUser $user
     * @return MessageParserException
     */
    public static function invalidUser(ApplicationUser $user)
    {
        return new self($user, self::INVALID_USER, 'User is not valid!');
    }
}
