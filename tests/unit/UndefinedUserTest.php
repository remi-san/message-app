<?php
namespace MessageApp\Test;

use MessageApp\User\ApplicationUserId;
use MessageApp\User\UndefinedApplicationUser;

class UndefinedUserTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function test()
    {
        $object = new \stdClass();
        $userId = new ApplicationUserId();

        $user = new UndefinedApplicationUser($userId, $object);

        $this->assertEquals($object, $user->getOriginalUser());
        $this->assertEquals($userId, $user->getId());
        $this->assertNull($user->getName());
        $this->assertEquals('en', $user->getPreferredLanguage());
    }
}
