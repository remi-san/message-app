<?php
namespace MessageApp\TestUser\Exception;

use MessageApp\User\Exception\UnsupportedUserException;

class UnsupportedUserExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldBeBuildable()
    {
        $exception = new UnsupportedUserException();

        $this->assertInstanceOf(\Exception::class, $exception);
    }
}
