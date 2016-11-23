<?php
namespace MessageApp\Test\User;

use MessageApp\User\ApplicationUserId;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\Source;
use MessageApp\User\UndefinedApplicationUser;
use TwitterMessageApp\Account\TwitterSource;

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
        $object = \Mockery::mock(Account::class);
        $source = \Mockery::mock(Source::class);

        $user = new UndefinedApplicationUser($object);

        $this->assertNull($user->getId());
        $this->assertNull($user->getName());
        $this->assertEquals('en', $user->getPreferredLanguage());
        $this->assertEquals($object, $user->getThirdPartyAccount($source));
    }
}
