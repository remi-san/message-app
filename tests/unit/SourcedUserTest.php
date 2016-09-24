<?php
namespace MessageApp\Test;

use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Entity\SourcedUser;

class SourcedUserTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testUser()
    {
        $name = 'adams';
        $language = 'en';

        $userId = $this->getApplicationUserId(33);
        $user = SourcedUser::createUser($userId, $name, $language);

        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($language, $user->getPreferredLanguage());
    }

    /**
     * @test
     */
    public function testReconstitution()
    {
        $this->assertTrue(SourcedUser::instantiateForReconstitution() instanceof SourcedUser);
    }
}
