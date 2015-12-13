<?php
namespace MessageApp\Test;

use Broadway\Domain\DateTime;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use League\Event\EventInterface;
use MessageApp\Test\Mock\AbstractUserManagerMock;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\Test\Mock\UserManager;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $userId;
    private $userName = 'player';

    private $user;

    private $userRepository;

    private $eventEmitter;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = $this->getApplicationUser($this->userId, $this->userName);
        $this->userRepository = $this->getUserRepository();
        $this->eventEmitter = \Mockery::mock('League\Event\EmitterInterface');
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testGet()
    {
        $this->userRepository->shouldReceive('find')->with($this->userId)->andReturn($this->user)->once();

        $manager = new AbstractUserManagerMock($this->userRepository, $this->eventEmitter);

        $this->assertEquals($this->user, $manager->get($this->userId));
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->userRepository->shouldReceive('save')->with($this->user)->once();

        $event = \Mockery::mock(EventInterface::class);

        $this->user
            ->shouldReceive('getUncommittedEvents')
            ->andReturn([\Mockery::mock(new DomainMessage(null, null, new Metadata(), $event, DateTime::now()))])
            ->once();

        $this->eventEmitter->shouldReceive('emit')->with($event)->once();

        $manager = new AbstractUserManagerMock($this->userRepository, $this->eventEmitter);
        $manager->save($this->user);
    }
}
