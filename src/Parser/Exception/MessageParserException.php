<?php

namespace MessageApp\Parser\Exception;

use MessageApp\Parser\LocalizedUser;

class MessageParserException extends \Exception
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
     * @var LocalizedUser
     */
    private $user;

    /**
     * @var string
     */
    private $codeName;

    /**
     * Constructor
     *
     * @param LocalizedUser $user
     * @param string        $codeName
     * @param string        $message
     * @param int           $code
     * @param \Exception    $previous
     */
    public function __construct(
        LocalizedUser $user = null,
        $codeName = null,
        $message = '',
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->codeName = $codeName;
        $this->user = $user;
    }

    /**
     * Returns the user
     *
     * @return LocalizedUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getCodeName()
    {
        return $this->codeName;
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotJoinMultipleUsers(LocalizedUser $user)
    {
        return new self($user, self::JOIN_MULTIPLE_USERS, 'You have to provide one (and only one) user to join!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotJoinUnregisteredUser(LocalizedUser $user)
    {
        return new self($user, self::JOIN_UNREGISTERED_USER, 'You cannot join a user who is not registered!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotJoinUserWithoutAGame(LocalizedUser $user)
    {
        return new self($user, self::JOIN_NO_GAME, 'You cannot join a player with no game!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotJoinYourself(LocalizedUser $user)
    {
        return new self($user, self::JOIN_YOURSELF, 'You cannot join yourself!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotJoinIfGameAlreadyRunning(LocalizedUser $user)
    {
        return new self($user, self::JOIN_GAME_RUNNING, 'You already have a game running!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotParseMessage(LocalizedUser $user)
    {
        return new self($user, self::PARSE_ERROR, 'Could not parse message!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotStartGameUserIsNotIn(LocalizedUser $user)
    {
        return new self($user, self::START_NOT_IN, 'You cannot start a game you are not in!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotLeaveGameUserIsNotIn(LocalizedUser $user)
    {
        return new self($user, self::LEAVE_NOT_IN, 'You cannot leave a game you are not in!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotFindGameForUser(LocalizedUser $user)
    {
        return new self(
            $user,
            self::GAME_NOT_FOUND,
            'The game or associated player was not found. Try starting/joining a game first.'
        );
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function cannotCreateMultipleGames(LocalizedUser $user)
    {
        return new self($user, self::CREATE_MULTIPLE, 'You already have a game running!');
    }

    /**
     * @param LocalizedUser $user
     * @return MessageParserException
     */
    public static function invalidUser(LocalizedUser $user)
    {
        return new self($user, self::INVALID_USER, 'User is not valid!');
    }
}
