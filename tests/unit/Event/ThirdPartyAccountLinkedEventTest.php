<?php
namespace MessageApp\Test\Event;

use MessageApp\Event\ThirdPartyAccountLinkedEvent;
use MessageApp\User\ApplicationUserId;
use MessageApp\User\ThirdParty\Account;
use Mockery\Mock;

class ThirdPartyAccountLinkedEventTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApplicationUserId | Mock */
    private $userId;

    /** @var Account | Mock */
    private $thirdPartyAccount;

    public function setUp()
    {
        $this->userId = \Mockery::mock(ApplicationUserId::class);
        $this->thirdPartyAccount = \Mockery::mock(Account::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function itShouldCreateTheEvent()
    {
        $event = new ThirdPartyAccountLinkedEvent($this->userId, $this->thirdPartyAccount);

        $this->assertEquals($this->userId, $event->getUserId());
        $this->assertEquals($this->thirdPartyAccount, $event->getThirdPartyAccount());
    }
}
