<?php
namespace MessageApp\Test;

use MessageApp\Test\Mock\InDatabaseUserManagerMock;
use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\Test\Mock\UserManager;

class InDatabaseUserManagerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $userId;
    private $userName = 'player';

    private $user;

    private $userRepository;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = $this->getApplicationUser($this->userId, $this->userName);
        $this->userRepository = $this->getUserRepository();
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

        $manager = new InDatabaseUserManagerMock($this->userRepository);

        $this->assertEquals($this->user, $manager->get($this->userId));
    }

    /**
     * @test
     */
    public function testSave()
    {
        $this->userRepository->shouldReceive('save')->with($this->user)->once();

        $manager = new InDatabaseUserManagerMock($this->userRepository);
        $manager->save($this->user);
    }
}
