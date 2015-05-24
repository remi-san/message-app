<?php
namespace MessageApp\Test;

use MessageApp\User\UndefinedApplicationUser;

class UndefinedUserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function test()
    {
        $object = new \stdClass();
        $user = new UndefinedApplicationUser($object);

        $this->assertEquals($object, $user->getOriginalUser());
    }
} 