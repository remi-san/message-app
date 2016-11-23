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
    public function testUnsupportedUserConstructor()
    {
        new UnsupportedUserException();
    }
}
