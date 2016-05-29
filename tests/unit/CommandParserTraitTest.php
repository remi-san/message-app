<?php
namespace MessageApp\Test;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Test\Mock\CommandParser;
use MessageApp\User\ApplicationUser;
use MessageApp\User\UndefinedApplicationUser;

class CommandParserTraitTest extends \PHPUnit_Framework_TestCase
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
    public function itShouldThrowAnExceptionIfUserIsUndefined()
    {
        $this->setExpectedException(MessageParserException::class);

        $parser = new CommandParser();
        $parser->testableCheckUser(\Mockery::mock(UndefinedApplicationUser::class));
    }

    /**
     * @test
     */
    public function itShouldDoNothingIfUserIsNotUndefined()
    {
        $parser = new CommandParser();
        $parser->testableCheckUser(\Mockery::mock(ApplicationUser::class));
    }
}
