<?php
namespace MessageApp\Test\User\Entity;

use MessageApp\User\ApplicationUserId;
use MessageApp\User\Entity\SourcedUser;
use MessageApp\User\ThirdParty\Account;
use MessageApp\User\ThirdParty\Source;
use Mockery\Mock;

class SourcedUserTest extends \PHPUnit_Framework_TestCase
{
    /** @var string */
    private $name;

    /** @var string */
    private $language;

    /** @var ApplicationUserId */
    private $userId;

    /** @var Account | Mock */
    private $account;

    /** @var Account | Mock */
    private $otherAccount;

    /** @var Source | Mock */
    private $source;

    public function setUp()
    {
        $this->name = 'adams';
        $this->language = 'en';
        $this->userId = new ApplicationUserId(33);

        $this->account = \Mockery::mock(Account::class);
        $this->otherAccount = \Mockery::mock(Account::class);
        $this->source = \Mockery::mock(Source::class);
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
        $user = SourcedUser::createUser($this->userId, $this->name, $this->language);

        $this->assertEquals($this->userId, $user->getId());
        $this->assertEquals((string) $this->userId, $user->getAggregateRootId());
        $this->assertEquals($this->name, $user->getName());
        $this->assertEquals($this->language, $user->getPreferredLanguage());
    }

    /**
     * @test
     */
    public function itShouldLinkToThirdPartyAccount()
    {
        $this->givenAGivenSource();
        $this->givenAnAccountWithThisSource();

        $user = SourcedUser::createUser($this->userId, $this->name, $this->language);
        $user->linkToThirdPartyAccount($this->account);

        $this->assertEquals([$this->account], $user->getThirdPartyAccounts());
    }

    /**
     * @test
     */
    public function itShouldReplaceThirdPartyAccount()
    {
        $this->givenAGivenSource();
        $this->givenAnAccountWithThisSource();
        $this->givenAnOtherAccountWithThisSource();

        $user = SourcedUser::createUser($this->userId, $this->name, $this->language);
        $user->linkToThirdPartyAccount($this->account);
        $user->linkToThirdPartyAccount($this->otherAccount);

        $this->assertEquals([$this->otherAccount], $user->getThirdPartyAccounts());
    }

    /**
     * @test
     */
    public function itShouldReconstructUser()
    {
        $this->assertTrue(SourcedUser::instantiateForReconstitution() instanceof SourcedUser);
    }

    private function givenAGivenSource()
    {
        $this->source->shouldReceive('__toString')->andReturn('source');
    }

    private function givenAnAccountWithThisSource()
    {
        $this->account->shouldReceive('getSource')->andReturn($this->source);
    }

    private function givenAnOtherAccountWithThisSource()
    {
        $this->otherAccount->shouldReceive('getSource')->andReturn($this->source);
    }
}
