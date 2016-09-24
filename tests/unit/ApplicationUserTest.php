<?php
namespace MessageApp\Test;

use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\User\Entity\ApplicationUser;

class ApplicationUserTest extends \PHPUnit_Framework_TestCase
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
        $user = ApplicationUser::createUser($userId, $name, $language);

        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($language, $user->getPreferredLanguage());
    }

    /**
     * @test
     */
    public function testReconstitution()
    {
        $this->assertTrue(ApplicationUser::instantiateForReconstitution() instanceof ApplicationUser);
    }
}
