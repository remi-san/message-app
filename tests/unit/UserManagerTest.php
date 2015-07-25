<?php
namespace MessageApp\Test;

use MessageApp\Test\Mock\MessageAppMocker;
use MessageApp\Test\Mock\UserManager;
use MessageApp\User\InMemoryUserManager;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    use MessageAppMocker;

    private $playerId = 1;
    private $playerName = 'player';

    private $user;

    public function setUp()
    {
        $this->user = $this->getApplicationUser($this->playerId, $this->playerName);
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

        $this->assertEquals($this->user, $manager->get($this->user));
    }

    /**
     * @test
     */
    public function testCreate()
    {

        $manager = new UserManager();
        $manager->create($this->user);

        $this->assertEquals($this->playerId, $manager->get($this->user)->getId());
        $this->assertEquals($this->playerName, $manager->get($this->user)->getName());
    }

    /**
     * @test
     */
    public function testCreateWhenNotExisting()
    {

        $manager = new UserManager();
        $user = $manager->get($this->user);

        $this->assertEquals($this->playerId, $user->getId());
        $this->assertEquals($this->playerName, $user->getName());
    }

    /**
     * @test
     */
    public function testGetUserWithIllegalObject()
    {
        $this->setExpectedException('\\MessageApp\\User\\Exception\\UnsupportedUserException');

        $manager = new UserManager();
        $manager->get(null);
    }
}
