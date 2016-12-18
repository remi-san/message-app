<?php

namespace MessageApp\Test\Parser\Exception;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\ParsingUser;

class MessageParserExceptionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ParsingUser */
    private $user;

    public function setUp()
    {
        $this->user = \Mockery::mock(ParsingUser::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testCannotJoinMultipleUsers()
    {
        $exception = MessageParserException::cannotJoinMultipleUsers($this->user);
        $this->assertEquals(MessageParserException::JOIN_MULTIPLE_USERS, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotJoinUnregisteredUser()
    {
        $exception = MessageParserException::cannotJoinUnregisteredUser($this->user);
        $this->assertEquals(MessageParserException::JOIN_UNREGISTERED_USER, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotJoinUserWithoutAGame()
    {
        $exception = MessageParserException::cannotJoinUserWithoutAGame($this->user);
        $this->assertEquals(MessageParserException::JOIN_NO_GAME, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotJoinYourself()
    {
        $exception = MessageParserException::cannotJoinYourself($this->user);
        $this->assertEquals(MessageParserException::JOIN_YOURSELF, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotJoinIfGameAlreadyRunning()
    {
        $exception = MessageParserException::cannotJoinIfGameAlreadyRunning($this->user);
        $this->assertEquals(MessageParserException::JOIN_GAME_RUNNING, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotParseMessage()
    {
        $exception = MessageParserException::cannotParseMessage($this->user);
        $this->assertEquals(MessageParserException::PARSE_ERROR, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotStartGameUserIsNotIn()
    {
        $exception = MessageParserException::cannotStartGameUserIsNotIn($this->user);
        $this->assertEquals(MessageParserException::START_NOT_IN, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotLeaveGameUserIsNotIn()
    {
        $exception = MessageParserException::cannotLeaveGameUserIsNotIn($this->user);
        $this->assertEquals(MessageParserException::LEAVE_NOT_IN, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotFindGameForUser()
    {
        $exception = MessageParserException::cannotFindGameForUser($this->user);
        $this->assertEquals(MessageParserException::GAME_NOT_FOUND, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testCannotCreateMultipleGames()
    {
        $exception = MessageParserException::cannotCreateMultipleGames($this->user);
        $this->assertEquals(MessageParserException::CREATE_MULTIPLE, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }

    /**
     * @test
     */
    public function testInvalidUser()
    {
        $exception = MessageParserException::invalidUser($this->user);
        $this->assertEquals(MessageParserException::INVALID_USER, $exception->getCodeName());
        $this->assertEquals($this->user, $exception->getUser());
    }
}
