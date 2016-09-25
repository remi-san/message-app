<?php

namespace MessageApp\Test;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\LocalizedUser;

class MessageParserExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
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
        $exception = MessageParserException::cannotJoinMultipleUsers(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::JOIN_MULTIPLE_USERS, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotJoinUnregisteredUser()
    {
        $exception = MessageParserException::cannotJoinUnregisteredUser(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::JOIN_UNREGISTERED_USER, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotJoinUserWithoutAGame()
    {
        $exception = MessageParserException::cannotJoinUserWithoutAGame(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::JOIN_NO_GAME, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotJoinYourself()
    {
        $exception = MessageParserException::cannotJoinYourself(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::JOIN_YOURSELF, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotJoinIfGameAlreadyRunning()
    {
        $exception = MessageParserException::cannotJoinIfGameAlreadyRunning(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::JOIN_GAME_RUNNING, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotParseMessage()
    {
        $exception = MessageParserException::cannotParseMessage(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::PARSE_ERROR, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotStartGameUserIsNotIn()
    {
        $exception = MessageParserException::cannotStartGameUserIsNotIn(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::START_NOT_IN, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotLeaveGameUserIsNotIn()
    {
        $exception = MessageParserException::cannotLeaveGameUserIsNotIn(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::LEAVE_NOT_IN, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotFindGameForUser()
    {
        $exception = MessageParserException::cannotFindGameForUser(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::GAME_NOT_FOUND, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testCannotCreateMultipleGames()
    {
        $exception = MessageParserException::cannotCreateMultipleGames(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::CREATE_MULTIPLE, $exception->getCodeName());
    }

    /**
     * @test
     */
    public function testInvalidUser()
    {
        $exception = MessageParserException::invalidUser(\Mockery::mock(LocalizedUser::class));
        $this->assertEquals(MessageParserException::INVALID_USER, $exception->getCodeName());
    }
}
