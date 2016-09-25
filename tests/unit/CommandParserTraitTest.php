<?php
namespace MessageApp\Test;

use MessageApp\Parser\Exception\MessageParserException;
use MessageApp\Parser\LocalizedUser;
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
        $parser->testableCheckUser(\Mockery::mock(LocalizedUser::class, function ($user) {
            $user->shouldReceive('isDefined')->andReturn(false);
        }));
    }

    /**
     * @test
     */
    public function itShouldDoNothingIfUserIsNotUndefined()
    {
        $parser = new CommandParser();
        $parser->testableCheckUser(\Mockery::mock(LocalizedUser::class, function ($user) {
            $user->shouldReceive('isDefined')->andReturn(true);
        }));
    }
}
