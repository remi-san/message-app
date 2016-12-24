<?php
namespace MessageApp\Test\User;

use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\Source;
use MessageApp\User\UndefinedApplicationUser;
use Mockery\Mock;

class UndefinedApplicationUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var Account | Mock */
    private $account;

    /** @var Account | Mock */
    private $otherAccount;

    /** @var Source | Mock */
    private $source;

    /** @var Source | Mock */
    private $otherSource;

    public function setUp()
    {
        $this->account = \Mockery::mock(Account::class);
        $this->otherAccount = \Mockery::mock(Account::class);
        $this->source = \Mockery::mock(Source::class);
        $this->otherSource = \Mockery::mock(Source::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldBuildTheUser()
    {
        $this->givenAccountHasAGivenSource();

        $user = new UndefinedApplicationUser($this->account);

        $this->assertNull($user->getId());
        $this->assertNull($user->getName());
        $this->assertEquals('en', $user->getPreferredLanguage());
        $this->assertEquals($this->account, $user->getThirdPartyAccount($this->source));
    }

    /**
     * @test
     */
    public function itShouldReturnNothingIfGivenAnotherSource()
    {
        $this->givenAccountHasAGivenSource();

        $user = new UndefinedApplicationUser($this->account);

        $this->assertNull($user->getThirdPartyAccount($this->otherSource));
    }

    private function givenAccountHasAGivenSource()
    {
        $this->source->shouldReceive('__toString')->andReturn('source');
        $this->account->shouldReceive('getSource')->andReturn($this->source);
    }
}
