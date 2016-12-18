<?php
namespace MessageApp\Test\Parser;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\ParsingUser;
use MessageApp\Test\Mock\CommandParser;
use MessageApp\User\ApplicationUser;
use MessageApp\User\UndefinedApplicationUser;
use Mockery\Mock;

class CommandParserTraitTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommandParser */
    private $parser;

    /** @var ParsingUser | Mock */
    private $user;

    public function setUp()
    {
        $this->parser = new CommandParser();
        $this->user = \Mockery::mock(ParsingUser::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionIfUserIsUndefined()
    {
        $this->givenUserIsNotDefined();

        $this->setExpectedException(MessageParserException::class);

        $this->parser->testableCheckUser($this->user);
    }

    /**
     * @test
     */
    public function itShouldDoNothingIfUserIsNotUndefined()
    {
        $this->givenUserIsDefined();

        $this->parser->testableCheckUser($this->user);
    }

    private function givenUserIsNotDefined()
    {
        $this->user->shouldReceive('isDefined')->andReturn(false);
    }

    private function givenUserIsDefined()
    {
        $this->user->shouldReceive('isDefined')->andReturn(true);
    }
}
