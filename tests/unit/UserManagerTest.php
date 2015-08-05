<?php
namespace MessageApp\Test;

use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\Test\Mock\UserManager;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $userId;
    private $userName = 'player';

    private $user;

    public function setUp()
    {
        $this->userId  = $this->getApplicationUserId(1);
        $this->user = $this->getApplicationUser($this->userId, $this->userName);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testSave()
    {
        $manager = new UserManager();
        $manager->save($this->user);

        $this->assertEquals($this->user, $manager->get($this->userId));
    }

    /**
     * @test
     */
    public function testCreate()
    {
        $manager = new UserManager();
        $user = $manager->create($this->user);

        $this->assertEquals($this->userId, $user->getId());
        $this->assertEquals($this->userName, $user->getName());
    }

    /**
     * @test
     */
    public function testWhenNotExisting()
    {
        $manager = new UserManager();
        $user = $manager->get($this->userId);

        $this->assertNull($user);
    }
}
