<?php

namespace MessageApp\Test\Parser;

use MessageApp\Parser\UndefinedParsingUser;
use MessageApp\User\ThirdParty\Account;

class UndefinedParsingUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var Account */
    private $account;

    /**
     * Init
     */
    public function setUp()
    {
        $this->account = \Mockery::mock(Account::class);
    }

    /**
     * Close
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldCreateAnUndefinedParsingUser()
    {
        $user = new UndefinedParsingUser($this->account);

        $this->assertNull($user->getId());
        $this->assertNull($user->getName());
        $this->assertFalse($user->isDefined());
        $this->assertEquals('en', $user->getPreferredLanguage());
        $this->assertEquals($this->account, $user->getAccount());
    }
}
