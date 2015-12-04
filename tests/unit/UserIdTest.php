<?php
namespace MessageApp\Test;

use MessageApp\User\ApplicationUserId;
use Rhumsaa\Uuid\Uuid;

class UserIdTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testGenerateId()
    {
        $id = new ApplicationUserId();

        $this->assertTrue(Uuid::isValid($id->getId()));
        $this->assertTrue(Uuid::isValid($id->__toString()));
    }

    public function testGivenId()
    {
        $vId = 42;
        $id = new ApplicationUserId($vId);

        $this->assertEquals($vId, $id->getId());
        $this->assertEquals($vId, $id->__toString());
    }
}
